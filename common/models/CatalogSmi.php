<?php

namespace common\models;

use Yii;
use omgdef\multilingual\MultilingualBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use common\models\query\CatalogSmiQuery;

/**
 * This is the model class for table "catalog_smi".
 *
 * @property int $id
 * @property string $image_path
 * @property string $image_base_url
 * @property int $created_at
 * @property int $title
 * @property int $updated_at
 *
 * @property CatalogSmiLang[] $catalogSmiLangs
 * @property Smi[] $smis
 */
class CatalogSmi extends ActiveRecord
{
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog_smi}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['image_path', 'image_base_url'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title' ,'image_path', 'image_base_url'], 'string', 'max' => 512],
            [['image', ], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'image' => Yii::t('common', 'Logo'),
            'title' => Yii::t('common', 'Title'),
//            'image_path' => Yii::t('common', 'Image Path'),
//            'image_base_url' => Yii::t('common', 'Image Base Url'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogSmiLangs()
    {
        return $this->hasMany(CatalogSmiLang::className(), ['cat_smi_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmis()
    {
        return $this->hasMany(Smi::className(), ['cat_smi_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CatalogSmiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CatalogSmiQuery(get_called_class());
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'image_path',
                'baseUrlAttribute' => 'image_base_url',
            ],
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'cat_smi_id',
                'tableName' => "{{%catalog_smi_lang}}",
                'attributes' => [
                    'title',
                ]
            ],
        ];
    }

}
