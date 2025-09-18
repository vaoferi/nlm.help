<?php

namespace common\models;

use console\controllers\CronController;
use Yii;

/**
 * This is the model class for table "{{%cron_log_detail_error}}".
 *
 * @property int $id
 * @property int $cron_log_detail_id
 * @property string $description
 * @property int $status
 * @property int $created_at
 *
 * @property CronLogDetail $cronLogDetail
 */
class CronLogDetailError extends \yii\db\ActiveRecord
{
    const STATUS_SIMPLE_ERROR = 0;
    const STATUS_SAVE_ERROR = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cron_log_detail_error}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cron_log_detail_id', 'status'], 'required'],
            [['cron_log_detail_id', 'status', 'created_at'], 'integer'],
            [['description'], 'string'],
            ['status', 'in', 'range' => array_keys(self::statuses()), 'allowArray' => true],
            [['status'], 'default', 'value' => self::STATUS_SIMPLE_ERROR],
            [['cron_log_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => CronLogDetail::className(), 'targetAttribute' => ['cron_log_detail_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_SIMPLE_ERROR => Yii::t('common', 'Script was finished with simple error.'),
            self::STATUS_SAVE_ERROR => Yii::t('common', 'Script had an error trying to save item to the database.'),
        ];
    }

    public static function checkExistStatus($code)
    {
        return in_array($code, array_keys(self::statuses()));
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'cron_log_detail_id' => Yii::t('common', 'Cron Log Detail ID'),
            'description' => Yii::t('common', 'Description'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    public static function createErrorLogFromCron($errorText, $code = self::STATUS_SIMPLE_ERROR)
    {
        $code = self::checkExistStatus($code) ? $code : self::STATUS_SIMPLE_ERROR;
        if (!empty($errorText)) {
            $object = new self;
            $object->cron_log_detail_id = CronController::$log_id;
            $object->status = $code;
            $object->description = $errorText;
            $object->created_at = time();
            $object->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCronLogDetail()
    {
        return $this->hasOne(CronLogDetail::className(), ['id' => 'cron_log_detail_id']);
    }
}
