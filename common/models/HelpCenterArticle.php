<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%help_center_article}}".
 *
 * @property int $id
 * @property int $help_center_id
 * @property int $article_id
 *
 * @property Article $article
 * @property HelpCenter $helpCenter
 */
class HelpCenterArticle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_center_article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'help_center_id', 'article_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
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
            'article_id' => Yii::t('common', 'Article ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenter()
    {
        return $this->hasOne(HelpCenter::className(), ['id' => 'help_center_id']);
    }
}
