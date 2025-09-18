<?php
/**
 * Created by PhpStorm.
 * User: rex
 * Date: 14.01.19
 * Time: 17:38
 */

namespace common\validators;


use Embed\Adapters\Adapter;
use Embed\Embed;
use Yii;
use yii\base\Exception;
use yii\validators\UrlValidator;
use yii\validators\Validator;

class VideoValidator extends Validator
{
    public $acceptProviders = [];

    //You can set embed code to field if need.
    public $filter = false;

    //embed code field.
    public $embedCodeField = 'embed_code';

    /* @var $adapter Adapter */
    private $adapter = null;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->acceptProviders)) {
            $this->acceptProviders = Yii::$app->params['acceptProviders'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $result = $this->validateValue($value);
        if (!empty($result)) {
            $this->addError($model, $attribute, $result[0], $result[1]);
        }
        if (empty($result) && $this->filter === true) {
            $this->filter($model);
        }
    }

    /**
     * Set embed code to field if need.
     * @param $model
     */
    protected function filter($model)
    {
        $model->{$this->embedCodeField} = $this->adapter->getCode();
    }

    /**
     * @param mixed $value
     * @return array|null
     */
    public function validateValue($value)
    {
        $urlValidator = new UrlValidator();
        $msg = '';
        if (!$urlValidator->validate($value, $msg)) {
            return [$msg, []];
        }
        $this->adapter = Embed::create($value);
        $providerName = strtolower($this->adapter->providerName);
        if (!in_array($providerName, $this->acceptProviders)) {
            return [Yii::t('common', 'Invalid video provider. Please choose one of: {providers}', [
                'providers' => implode(', ', $this->acceptProviders)
            ]), []];
        }
        if ($this->adapter->getCode() === null) {
            return [Yii::t('common', 'Video URL is invalid.'), []];
        }
        return [];
    }
}