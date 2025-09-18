<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article_cron}}".
 *
 * @property int $id
 * @property string $client
 * @property int $status
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 */
class ArticleCron extends \yii\db\ActiveRecord
{
    const CLIENT_VK = 'vk';
    const CLIENT_FB = 'fb';
    const CLIENT_OK = 'ok';

    const STATUS_NOT_POSTED = 0;
    const STATUS_POSTED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_cron}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client', 'date'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_NOT_POSTED],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            ['client', 'in', 'range' => array_keys(self::clients())],
            [['date'], 'safe'],
            [['client'], 'string', 'max' => 255],
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_NOT_POSTED => Yii::t('common', 'Not Posted'),
            self::STATUS_POSTED => Yii::t('common', 'Posted'),
        ];
    }

    public static function clients()
    {
        return [
            self::CLIENT_VK => Yii::t('common', 'Vkontakte'),
            self::CLIENT_FB => Yii::t('common', 'Facebook'),
            self::CLIENT_OK => Yii::t('common', 'Odnoklassniki'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'client' => Yii::t('common', 'Client'),
            'status' => Yii::t('common', 'Status'),
            'date' => Yii::t('common', 'Date'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
