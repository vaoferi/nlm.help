<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%magazine}}".
 *
 * @property int $id
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $number
 * @property string $attachment_path
 * @property string $attachment_base_url
 * @property string $title;
 * @property string $alt;
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Magazine extends \yii\db\ActiveRecord
{
    public $thumbnail;
    public $attachment;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%magazine}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'attachment',
                'pathAttribute' => 'attachment_path',
                'baseUrlAttribute' => 'attachment_base_url',
            ],
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'magazine_id',
                'tableName' => "{{%magazine_lang}}",
                'attributes' => [
                    'title', 'alt',
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attachment', 'thumbnail'], 'safe'],
            [['title', 'alt'], 'string', 'max' => 255],
            ['title', 'required'],
            [['number', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['thumbnail_base_url', 'thumbnail_path', 'attachment_path', 'attachment_base_url'], 'string', 'max' => 1024],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'number' => Yii::t('common', 'Number'),
            'attachment_path' => Yii::t('common', 'Attachment Path'),
            'attachment_base_url' => Yii::t('common', 'Attachment Base Url'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'attachment' => Yii::t('common', 'Attachment'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
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
     * {@inheritdoc}
     * @return \common\models\query\MagazineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MagazineQuery(get_called_class());
    }

    /**
     * @param array $options
     * @return bool|string
     * @throws \yii\base\InvalidConfigException
     */
    public function glideThumbnail($options = [])
    {
        $options = array_merge([
            'glide/index',
            'path' => $this->thumbnail_path,
        ], $options);
        return Yii::$app->glide->createSignedUrl($options, true);
    }
}
