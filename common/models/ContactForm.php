<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%contact_form}}".
 *
 * @property int $id
 * @property string $full_name
 * @property string $phone
 * @property string $email
 * @property string $body
 * @property int $help_center_id
 * @property int $is_new
 * @property int $created_at
 * @property int $updated_at
 *
 * @property HelpCenter $helpCenter
 */
class ContactForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contact_form}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['help_center_id', 'is_new', 'created_at', 'updated_at'], 'integer'],
            [['full_name', 'phone', 'email'], 'string', 'max' => 512],
            [['help_center_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpCenter::className(), 'targetAttribute' => ['help_center_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'full_name' => Yii::t('common', 'Full Name'),
            'phone' => Yii::t('common', 'Phone'),
            'email' => Yii::t('common', 'Email'),
            'body' => Yii::t('common', 'Body'),
            'help_center_id' => Yii::t('common', 'Help Center ID'),
            'is_new' => Yii::t('common', 'Is New'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @param bool $bool
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function updateIsNew(bool $bool)
    {
        if ($this->is_new != $bool) {
            $this->is_new = $bool;
            $this->save(false);
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenter()
    {
        return $this->hasOne(HelpCenter::className(), ['id' => 'help_center_id']);
    }
}
