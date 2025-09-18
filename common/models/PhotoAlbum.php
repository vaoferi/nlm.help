<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%photo_album}}".
 *
 * @property int $id
 * @property int $status 0 => not active, 1 => active
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $slug
 * @property string $title
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @property Photo[] $photos
 */
class PhotoAlbum extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 1;

    public $uploadPhotos;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%photo_album}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true,
            ],
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'photo_album_id',
                'tableName' => "{{%photo_album_lang}}",
                'attributes' => [
                    'title',
                ]
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'uploadPhotos',
                'multiple' => true,
                'uploadRelation' => 'photos',
                'pathAttribute' => 'photo_path',
                'baseUrlAttribute' => 'photo_base_url',
                'orderAttribute' => 'order'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['slug'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            ['uploadPhotos', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', 'Title'),
            'uploadPhotos' => Yii::t('common', 'Upload Photos'),
        ];
    }

    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DELETED => Yii::t('common', 'Deleted'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['photo_album_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PhotoAlbumQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PhotoAlbumQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getThumbnailPath()
    {
        $path = '';
        if ($this->photos) {
            $lastPhoto = array_slice($this->photos, -1);
            /** @var Photo $photo */
            $photo = array_pop($lastPhoto);
            $path = $photo->photo_path;
        }
        return $path;
    }
}
