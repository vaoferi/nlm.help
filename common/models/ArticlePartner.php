<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_partner}}".
 *
 * @property int $id
 * @property int $article_id
 * @property int $partner_id
 *
 * @property Partner $partner
 * @property Article $article
 */
class ArticlePartner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_partner}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'partner_id'], 'integer'],
            [['article_id', 'partner_id'], 'unique', 'targetAttribute' => ['article_id', 'partner_id']],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['partner_id' => 'id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'article_id' => Yii::t('common', 'Article ID'),
            'partner_id' => Yii::t('common', 'Partner ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}
