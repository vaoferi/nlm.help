<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\components\payment\liqpay;
use InvalidArgumentException;
use yii\base\Component;

/**
 * Liqpay Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        LiqPay
 * @package         liqpay/liqpay
 * @version         3.0
 * @author          Liqpay
 * @copyright       Copyright (c) 2014 Liqpay
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * LIQPAY API       https://www.liqpay.ua/documentation/en
 *
 */

/**
 * Payment method liqpay process
 *
 * @author      Liqpay <support@liqpay.ua>
 */
class LiqPay extends Component
{
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';
    const CURRENCY_UAH = 'UAH';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_RUR = 'RUR';

    public $public_key;
    public $private_key;

    private $apiUrl = 'https://www.liqpay.ua/api/';
    private $checkoutUrl = 'https://www.liqpay.ua/api/3/checkout';

    public $supportedCurrencies = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_UAH,
        self::CURRENCY_RUB,
        self::CURRENCY_RUR,
    ];

    private $serverResponseCode = null;

    public function init() : void
    {
        if (empty($this->public_key)) {
            throw new InvalidArgumentException('public_key is empty');
        }

        if (empty($this->private_key)) {
            throw new InvalidArgumentException('private_key is empty');
        }
    }

    /**
     * Call API
     *
     * @param string $path
     * @param array $params
     * @param int $timeout
     *
     * @return array
     */
    public function api($path, $params = [], $timeout = 5) : array
    {
        if (!isset($params['version'])) {
            throw new InvalidArgumentException('version is null');
        }
        $url         = $this->apiUrl . $path;
        $public_key  = $this->public_key;
        $private_key = $this->private_key;
        $data        = $this->encodeParams(array_merge(compact('public_key'), $params));
        $signature   = $this->stringToSign($private_key.$data.$private_key);
        $postFields  = http_build_query(array(
            'data'  => $data,
            'signature' => $signature
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Avoid MITM vulnerability http://phpsecurity.readthedocs.io/en/latest/Input-Validation.html#validation-of-input-sources
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);    // Check the existence of a common name and also verify that it matches the hostname provided
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,$timeout);   // The number of seconds to wait while trying to connect
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);          // The maximum number of seconds to allow cURL functions to execute
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $this->serverResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($server_output);
    }

    /**
     * Return last api response http code
     *
     * @return string|null
     */
    public function getResponseCode()
    {
        return $this->serverResponseCode;
    }

    /**
     * cnb_form
     *
     * @param array $params
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function generateButton($params)
    {
        $language = 'ru';
        if (isset($params['language']) && $params['language'] == 'en') {
            $language = 'en';
        }

        $params    = $this->getParams($params);
        $data      = $this->encodeParams($params);
        $signature = $this->getSignature($params);

        return sprintf('
            <form method="POST" action="%s" accept-charset="utf-8">
                %s
                %s
                <input type="image" src="//static.liqpay.ua/buttons/p1%s.radius.png" name="btn_text" />
            </form>
            ',
            $this->checkoutUrl,
            sprintf('<input type="hidden" name="%s" value="%s" />', 'data', $data),
            sprintf('<input type="hidden" name="%s" value="%s" />', 'signature', $signature),
            $language
        );
    }

    /**
     * cnb_signature
     *
     * @param array $params
     *
     * @return string
     */
    public function getSignature($params)
    {
        $params      = $this->getParams($params);
        $private_key = $this->private_key;

        $json      = $this->encodeParams($params);
        $signature = $this->stringToSign($private_key . $json . $private_key);

        return $signature;
    }

    /**
     * cnb_params
     *
     * @param array $params
     *
     * @return array $params
     */
    private function getParams($params)
    {
        $params['public_key'] = $this->public_key;

        if (!isset($params['version'])) {
            throw new InvalidArgumentException('version is null');
        }
        if (!isset($params['amount'])) {
            throw new InvalidArgumentException('amount is null');
        }
        if (!isset($params['currency'])) {
            throw new InvalidArgumentException('currency is null');
        }
        if (!in_array($params['currency'], $this->supportedCurrencies)) {
            throw new InvalidArgumentException('currency is not supported');
        }
        if ($params['currency'] == self::CURRENCY_RUR) {
            $params['currency'] = self::CURRENCY_RUB;
        }
        if (!isset($params['description'])) {
            throw new InvalidArgumentException('description is null');
        }

        return $params;
    }

    /**
     * encode_params
     *
     * @param array $params
     * @return string
     */
    private function encodeParams($params)
    {
        return base64_encode(json_encode($params));
    }

    /**
     * decode_params
     *
     * @param string $params
     * @return array
     */
    public function decodeParams($params)
    {
        return json_decode(base64_decode($params), true);
    }

    /**
     * str_to_sign
     *
     * @param string $str
     *
     * @return string
     */
    public function stringToSign($str)
    {
        $signature = base64_encode(sha1($str, 1));

        return $signature;
    }
}
