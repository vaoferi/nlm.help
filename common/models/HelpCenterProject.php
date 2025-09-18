<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%help_center_project}}".
 *
 * @property int $id
 * @property int $help_center_id
 * @property int $project_id
 *
 * @property Project $project
 * @property HelpCenter $helpCenter
 */
class HelpCenterProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_center_project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'help_center_id', 'project_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'project_id' => Yii::t('common', 'Project ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenter()
    {
        return $this->hasOne(HelpCenter::className(), ['id' => 'help_center_id']);
    }
}
