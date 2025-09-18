<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_smi_lang".
 *
 * @property int $id
 * @property int $cat_smi_id
 * @property string $language
 * @property string $title
 *
 * @property CatalogSmi $catSmi
 */
class CatalogSmiLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog_smi_lang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_smi_id', 'language'], 'required'],
            [['cat_smi_id'], 'integer'],
            [['language'], 'string', 'max' => 2],
            [['title'], 'string', 'max' => 512],
            [['cat_smi_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogSmi::className(), 'targetAttribute' => ['cat_smi_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'cat_smi_id' => Yii::t('common', 'Cat Smi ID'),
            'language' => Yii::t('common', 'Language'),
            'title' => Yii::t('common', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatSmi()
    {
        return $this->hasOne(CatalogSmi::className(), ['id' => 'cat_smi_id']);
    }
}
