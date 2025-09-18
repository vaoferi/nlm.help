<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%photo}}".
 *
 * @property int $id
 * @property string $photo_base_url
 * @property string $photo_path
 * @property string $title
 * @property string $description
 * @property string $alt
 * @property int $photo_album_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $order
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property PhotoAlbum $photoAlbum
 */
class Photo extends \yii\db\ActiveRecord
{
    public $photo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%photo}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'photo_id',
                'tableName' => "{{%photo_lang}}",
                'attributes' => [
                    'title', 'description', 'alt'
                ]
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'photo',
                'pathAttribute' => 'photo_path',
                'baseUrlAttribute' => 'photo_base_url',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['photo', 'safe'],
            [['photo_album_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'order'], 'integer'],
            [['photo_base_url', 'photo_path'], 'string', 'max' => 1024],
            [['description'], 'string'],
            [['title', 'alt'], 'string', 'max' => 512],
            [['photo_album_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhotoAlbum::className(), 'targetAttribute' => ['photo_album_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'photo_base_url' => Yii::t('common', 'Photo Base Url'),
            'photo_path' => Yii::t('common', 'Photo Path'),
            'photo_album_id' => Yii::t('common', 'Photo Album ID'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'alt' => Yii::t('common', 'Alt'),
            'order' => Yii::t('common', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoAlbum()
    {
        return $this->hasOne(PhotoAlbum::className(), ['id' => 'photo_album_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }


    /**
     * {@inheritdoc}
     * @return \common\models\query\PhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PhotoQuery(get_called_class());
    }

    public function glide($options = [])
    {
        $options = array_merge([
            'glide/index',
            'path' => $this->photo_path,
        ], $options);
        return Yii::$app->glide->createSignedUrl($options, true);
    }
}
