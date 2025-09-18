<?php

namespace frontend\models;

use common\models\HelpCenter;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $full_name;
    public $phone;
    public $email;
    public $body;
    public $help_center_id;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['full_name', 'email', 'body', 'verifyCode'], 'required'],
            ['phone', 'string'],
            // We need to sanitize them
            [['full_name', 'email', 'phone', 'body'], 'filter', 'filter' => 'strip_tags'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
            ['help_center_id', 'integer'],
            [['help_center_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpCenter::className(), 'targetAttribute' => ['help_center_id' => 'id']],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'full_name' => Yii::t('frontend', 'Full Name'),
            'email' => Yii::t('frontend', 'Email'),
            'body' => Yii::t('frontend', 'Body'),
            'phone' => Yii::t('frontend', 'Phone'),
            'verifyCode' => Yii::t('frontend', 'Verification Code')
        ];
    }


    /**
     * @return bool
     */
    public function contact()
    {
        if ($this->validate()) {
            $model = new \common\models\ContactForm();
            $model->setAttributes($this->getAttributes());
            return $model->save(false);
        } else {
            return false;
        }
    }
}
