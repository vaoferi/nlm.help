<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%help_center_service}}".
 *
 * @property int $id
 * @property int $help_center_id
 * @property string $service_name
 *
 * @property HelpCenter $helpCenter
 */
class HelpCenterService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_center_service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['help_center_id'], 'integer'],
            [['service_name'], 'string', 'max' => 255],
            ['service_name', 'in', 'range' => [array_keys(self::getServices())]],
            [['help_center_id', 'service_name'], 'unique', 'targetAttribute' => ['help_center_id', 'service_name']],
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
            'help_center_id' => Yii::t('common', 'Help Center ID'),
            'service_name' => Yii::t('common', 'Service Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenter()
    {
        return $this->hasOne(HelpCenter::className(), ['id' => 'help_center_id']);
    }

    /**
     * @return array
     */
    public static function getServices()
    {
        return [
            'medicine' => Yii::t('common', 'Medicine'),
            'shelter' => Yii::t('common', 'Shelter'),
            'food' => Yii::t('common', 'Food'),
        ];
    }
}
