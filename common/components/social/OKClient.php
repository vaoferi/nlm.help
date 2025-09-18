<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 06.05.19
 * Time: 15:56
 */

namespace common\components\social;


use yii\httpclient\Client;

class OKClient extends ClientAbstract implements ClientInterface
{
    /*
     * https://shtyrlyaev.ru/all/skript-avtopostinga-v-gruppu-odnoklassnikov/
     * https://apiok.ru/dev/app/group_app
     * Best size for links image preview 640x320.
     * App needs for postings in groups next rules: GROUP_CONTENT, VALUABLE_ACCESS and LONG_ACCESS_TOKEN. Rules should be
     * requested to api-support@ok.ru by email.
     *
     * https://apiok.ru/ext/oauth/server
     *
     * Example of oauth url:
     * https://connect.ok.ru/oauth/authorize?client_id=1278498816&scope=VALUABLE_ACCESS;GROUP_CONTENT;LONG_ACCESS_TOKEN&response_type=token&redirect_uri=https://oauth.mycdn.me/blank.html&layout=w
     */
    public $group_id;
    public $public_key;
    public $secret_key;

    const URL = "https://api.ok.ru/fb.do";

    /**
     * @param Message $message
     * @return bool|string
     * @throws \yii\base\InvalidConfigException
     */
    public function send(Message $message)
    {
        $accessToken = $this->getAccessToken();
        // Заменим переносы строк, чтоб не вываливалась ошибка аттача
        $messageJson = str_replace("\n", "\\n", $message->getText());
        $attachment = '{
                    "media": [
                        {
                            "type": "text",
                            "text": "' . $messageJson . '"
                        },
                        {
                            "type": "link",
                            "url": "'.$message->getUrl().'",
                            "buttonKey": "READ"
                        }
                    ]
                }';

        $params = [
            "application_key" => $this->public_key,
            "method" => "mediatopic.post",
            "gid" => $this->group_id,
            "type" => "GROUP_THEME",
            "attachment" => $attachment,
            "format" => "json",
            "text_link_preview" => true,
        ];
        $signature = md5($this->arrayToString($params) . md5("{$accessToken}{$this->secret_key}"));
        $params['access_token'] = $accessToken;
        $params['sig'] = $signature;

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::URL)
            ->setData($params)
            ->setOptions([
                CURLOPT_CONNECTTIMEOUT => 30, // connection timeout
                CURLOPT_TIMEOUT => 10, // data receiving timeout
            ])
            ->send();
        $responseData = $response->getData();

        if (isset($responseData['error_code'])) {
            return $responseData['error_code'];
        }

        return true;
    }

    /**
     * Method returns string with keys and values.
     * For example, 'application_key=CBAJFFcount=1format=json'
     * @param array $array
     * @return string
     */
    private function arrayToString(array $array) : string
    {
        ksort($array);

        $string = "";

        foreach($array as $key => $val) {
            if (is_array($val)) {
                $string .= $key."=".$this->arrayToString($val);
            } else {
                $string .= $key."=".$val;
            }
        }

        return $string;
    }

}