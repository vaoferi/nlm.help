<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "slider_sertificat".
 *
 * @property int $id
 * @property string $image_path
 * @property string $image_base_url
 * @property string $button_url
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property int $order
 *
 */
class SliderSertificat extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider_sertificat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['image', 'required'],
            [['text'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 100],
            [['button_text'], 'string', 'max' => 100],
            [['order', 'status', 'created_at', 'updated_at'], 'integer'],
            [['image_path', 'image_base_url', 'button_url'], 'string', 'max' => 512],
            ['button_url', 'url', 'defaultScheme' => 'http'],
        ];
    }

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
                'class' => MultilingualBehavior::class,
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'slider_id',
                'tableName' => "{{%slider_sert_lang}}",
                'attributes' => [
                    'title', 'text', 'button_text'
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'image_path' => Yii::t('common', 'Image Path'),
            'image_base_url' => Yii::t('common', 'Image Base Url'),
            'button_url' => Yii::t('common', 'Button Url'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'status' => Yii::t('common', 'Active'),
            'order' => Yii::t('common', 'Order'),
        ];
    }


    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT => Yii::t('common', 'Draft'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
        ];
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}
