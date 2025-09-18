<?php

namespace common\models;

use common\behaviors\Select2Behavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use omgdef\multilingual\MultilingualBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\validators\FilterValidator;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $short_description
 * @property string $description
 * @property int $status 0 => draft, 1 => active
 * @property int $required_amount
 * @property int $collected_amount
 * @property string $due_date
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $created_at
 * @property int $updated_at
 * @property int $published_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_finished
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @property ProjectAttachment[] $projectAttachments
 * @property PartnerProject[] $partnerProjects
 * @property Partner[] $partners
 * @property ProjectArticle[] $projectArticles
 * @property Article[] $articles
 */
class Project extends \yii\db\ActiveRecord
{
    public $thumbnail;

    public $attachments;

    //select2 values
    public $partnersTexts;
    public $articlesTexts;

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%project}}';
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
            [
                'class' => UploadBehavior::class,
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'projectAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'order',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
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
                'langForeignKey' => 'project_id',
                'tableName' => "{{%project_lang}}",
                'attributes' => [
                    'title', 'description', 'short_description'
                ]
            ],
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [
                    'partners',
                    'articles',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partners', 'articles'], 'safe'],
            [['title', 'required_amount'], 'required'],
            [['description'], 'string'],
            [['status', 'required_amount', 'collected_amount', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_finished'], 'integer'],
            [['due_date'], 'required'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title', 'short_description'], 'string', 'max' => 512],
            [['published_at'], 'default', 'value' => function () {
                return date(DATE_ISO8601);
            }],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['attachments', 'thumbnail'], 'safe'],
        ];
    }

    /**
     * @return float|int
     */
    public function getCollectedPercent()
    {
        if ($this->required_amount) {
            $percent = $this->collected_amount * 100 / $this->required_amount;
            return $percent > 100 ? 100 : $percent;
        }
        return 100;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'status' => Yii::t('common', 'Status'),
            'required_amount' => Yii::t('common', 'Required Amount'),
            'collected_amount' => Yii::t('common', 'Collected Amount'),
            'due_date' => Yii::t('common', 'Due Date'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'published_at' => Yii::t('common', 'Published At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'is_finished' => Yii::t('common', 'Is Finished'),
            'partnersIdx' => Yii::t('common', 'Partners'),
            'short_description' => Yii::t('common', 'Short Description'),
            'articles' => Yii::t('common', 'Articles'),
            'partners' => Yii::t('common', 'Partners'),
            'attachments' => Yii::t('common', 'Attachments'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAttachments()
    {
        return $this->hasMany(ProjectAttachment::className(), ['project_id' => 'id']);
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
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerProjects()
    {
        return $this->hasMany(PartnerProject::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['id' => 'partner_id'])->viaTable('{{%partner_project}}', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectArticles()
    {
        return $this->hasMany(ProjectArticle::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('{{%project_article}}', ['project_id' => 'id']);
    }

    /**
     * @return void
     */
    public function select2Init()
    {
        $partners = $this->getPartners()->joinWith('translation')->all();
        $this->partnersTexts = ArrayHelper::getColumn($partners, 'name');

        $articles = $this->getArticles()->joinWith('translation')->all();
        $this->articlesTexts = ArrayHelper::getColumn($articles, 'title');
    }
}
