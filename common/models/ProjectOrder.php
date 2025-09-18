<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%project_order}}".
 *
 * @property int $id
 * @property int $project_id
 * @property int $order
 *
 * @property Project $project
 */
class ProjectOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'order'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'project_id' => Yii::t('common', 'Project ID'),
            'order' => Yii::t('common', 'Order'),
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
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getOrder()
    {
        $query = new Query();
        $command = $query->select('project_id')
            ->from(self::tableName())
            ->orderBy(['order' => SORT_ASC])
            ->createCommand();
        $result = $command->queryAll();
        return ArrayHelper::getColumn($result, 'project_id');
    }
}
