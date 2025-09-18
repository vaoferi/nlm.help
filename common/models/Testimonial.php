<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%testimonial}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $thumbnail_path
 * @property string $thumbnail_base_url
 * @property int $created_at
 * @property int $updated_at
 */
class Testimonial extends \yii\db\ActiveRecord
{
    public $thumbnail;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%testimonial}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['thumbnail', 'safe'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'thumbnail_path', 'thumbnail_base_url'], 'string', 'max' => 512],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url',
            ],
            'multi_language' => [
                'class' => MultilingualBehavior::class,
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'testimonial_id',
                'tableName' => "{{%testimonial_lang}}",
                'attributes' => [
                    'title', 'text'
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
            'title' => Yii::t('common', 'Title'),
            'text' => Yii::t('common', 'Text'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
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
