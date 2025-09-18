<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%project_attachment}}".
 *
 * @property int $id
 * @property int $project_id
 * @property string $path
 * @property string $base_url
 * @property string $type
 * @property int $size
 * @property string $name
 * @property int $created_at
 *
 * @property Project $project
 */
class ProjectAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_attachment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'path'], 'required'],
            [['project_id', 'size', 'created_at'], 'integer'],
            [['path', 'base_url', 'type', 'name'], 'string', 'max' => 255],
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
            'path' => Yii::t('common', 'Path'),
            'base_url' => Yii::t('common', 'Base Url'),
            'type' => Yii::t('common', 'Type'),
            'size' => Yii::t('common', 'Size'),
            'name' => Yii::t('common', 'Name'),
            'created_at' => Yii::t('common', 'Created At'),
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
     * @param array $options
     * @return bool|string
     * @throws \yii\base\InvalidConfigException
     */
    public function glide($options = [])
    {
        $options = array_merge([
            'glide/index',
            'path' => $this->path,
        ], $options);
        return Yii::$app->glide->createSignedUrl($options, true);
    }
}
