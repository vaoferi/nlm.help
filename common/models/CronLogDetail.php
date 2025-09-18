<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cron_log_detail}}".
 *
 * @property int $id
 * @property string $command_name
 * @property int $time_start
 * @property int $time_end
 * @property int $status
 * @property string $description
 *
 * @property CronLogDetailError[] $cronLogDetailErrors
 */
class CronLogDetail extends \yii\db\ActiveRecord
{
    const STATUS_FAIL = 0;
    const STATUS_SUCCESS = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cron_log_detail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['command_name', 'time_start', 'status'], 'required'],
            [['time_start', 'time_end', 'status'], 'integer'],
            [['description'], 'string'],
            ['status', 'in', 'range' => array_keys(self::statuses()), 'allowArray' => true],
            [['status'], 'default', 'value' => self::STATUS_FAIL],
            [['command_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_FAIL => Yii::t('common', 'Script execution failed.'),
            self::STATUS_SUCCESS => Yii::t('common', 'Script execution completed successfully.'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'command_name' => Yii::t('common', 'Command Name'),
            'time_start' => Yii::t('common', 'Time Start'),
            'time_end' => Yii::t('common', 'Time End'),
            'status' => Yii::t('common', 'Status'),
            'description' => Yii::t('common', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCronLogDetailErrors()
    {
        return $this->hasMany(CronLogDetailError::className(), ['cron_log_detail_id' => 'id']);
    }
}
