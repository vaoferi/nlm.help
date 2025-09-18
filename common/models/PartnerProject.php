<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%partner_project}}".
 *
 * @property int $id
 * @property int $partner_id
 * @property int $project_id
 *
 * @property Project $project
 * @property Partner $partner
 */
class PartnerProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%partner_project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_id', 'project_id'], 'integer'],
            [['partner_id', 'project_id'], 'unique', 'targetAttribute' => ['partner_id', 'project_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['partner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'partner_id' => Yii::t('common', 'Partner ID'),
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
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }
}
