<?php

namespace common\models;

use common\validators\VideoValidator;
use omgdef\multilingual\MultilingualBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $embed_code
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Video extends \yii\db\ActiveRecord
{
    public $video;
    //kostyl
    public $video_en;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
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
                'langForeignKey' => 'video_id',
                'tableName' => "{{%video_lang}}",
                'attributes' => [
                    'title', 'description', 'embed_code'
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
//            ['video', 'required', 'when' => function(self $model) {
//                return $model->isNewRecord || empty($model->embed_code);
//            }, 'whenClient' => 'function(){return false;}'],
            ['video', VideoValidator::class, 'filter' => true],
            ['video_en', VideoValidator::class, 'filter' => true, 'embedCodeField' => 'embed_code_en'],
            [['video', 'video_en'], 'url'],
            [['description', 'embed_code'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'video' => Yii::t('common', 'Video'),
            'video_en' => Yii::t('common', 'Video') . ' (en)',
            'embed_code' => Yii::t('common', 'Embed Code')
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
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }
}
