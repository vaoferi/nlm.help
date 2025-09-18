<?php

namespace common\models;

use Yii;
use omgdef\multilingual\MultilingualBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "smi".
 *
 * @property int $id
 * @property int $cat_smi_id
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CatalogSmi $catSmi
 * @property SmiLang[] $smiLangs
 */
class Smi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%smi}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_smi_id'], 'required'],
            [['cat_smi_id', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 512],
            [['preview'], 'string'],
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
            'cat_smi_id' => Yii::t('common', 'СМИ'),
            'url' => Yii::t('common', 'Url'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'preview' => Yii::t('common', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatSmi()
    {
        return $this->hasOne(CatalogSmi::className(), ['id' => 'cat_smi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmiLangs()
    {
        return $this->hasMany(SmiLang::className(), ['smi_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SmiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SmiQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'smi_id',
                'tableName' => "{{%smi_lang}}",
                'attributes' => [
                    'preview',
                ]
            ],
        ];
    }

}
