<?php

namespace common\models;

use common\models\query\ArticleQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use omgdef\multilingual\MultilingualBehavior;
use phpDocumentor\Reflection\Types\This;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $view
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property string $image_before_base_url
 * @property string $image_before_path
 * @property string $image_after_base_url
 * @property string $image_after_path
 * @property string $short_description
 * @property string $about_us
 * @property string $about_us_path
 * @property string $about_us_base_url
 * @property integer $crossposting_status
 * @property array $attachments
 * @property integer $category_id
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $author
 * @property User $updater
 * @property ArticleCategory $category
 * @property ArticleAttachment[] $articleAttachments
 * @property ProjectArticle[] $projectArticles
 * @property ArticlePartner[] $articlePartners
 * @property HelpCenterArticle[] $helpCenterArticles
 * @property Partner[] $partners
 * @property Project[] $projects
 */
class Article extends ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    //select2 fields
    public $projectsTexts;
    public $partnersTexts;

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;
    public $about_us_thumbnail;
    public $image_before;
    public $image_after;

    /**
     * @inheritdoc
     */
    const MIN_FILES_SLIDER = 4;

    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @return ArticleQuery
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT => Yii::t('common', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('common', 'Published'),
        ];
    }

    /**
     * @inheritdoc
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
                'uploadRelation' => 'articleAttachments',
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
            [
                'class' => UploadBehavior::class,
                'attribute' => 'about_us_thumbnail',
                'pathAttribute' => 'about_us_path',
                'baseUrlAttribute' => 'about_us_base_url',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image_before',
                'pathAttribute' => 'image_before_path',
                'baseUrlAttribute' => 'image_before_base_url',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image_after',
                'pathAttribute' => 'image_after_path',
                'baseUrlAttribute' => 'image_after_base_url',
            ],
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'article_id',
                'tableName' => "{{%article_lang}}",
                'attributes' => [
                    'title', 'body', 'short_description'
                ]
            ],
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [
                    'projects',
                    'partners',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partners', 'projects'], 'safe'],
            //[['title', 'body'], 'required'],
            //['title', 'default', 'value' => 'This Page without translate'],
            [['slug'], 'unique'],
            ['slug', 'default', 'value' => (string)time()],
            [['body'], 'string'],
            [['published_at'], 'default', 'value' => function () {
                return date(DATE_ISO8601);
            }],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['category_id'], 'exist', 'targetClass' => ArticleCategory::class, 'targetAttribute' => 'id'],
            [['status', 'about_us'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['image_before_base_url', 'image_before_path'], 'string', 'max' => 1024],
            [['image_after_base_url', 'image_after_path'], 'string', 'max' => 1024],
            [['title', 'short_description', 'about_us_base_url', 'about_us_path'], 'string', 'max' => 512],
            [['view'], 'string', 'max' => 255],
            [['image_after', 'image_before'], 'required', 'when' => function ($model)  {
                return ($model->image_before || $model->image_after);
            }],
            [['thumbnail', 'about_us_thumbnail', 'image_before', 'image_after'], 'safe'],
            ['attachments', 'validateAttachmentsCount'],
            [['crossposting_status'], 'default', 'value' => 0],
            [['crossposting_status'], 'boolean'],
        ];
    }

    public function validateAttachmentsCount($attribute, $params)
    {
        if (is_array($this->{$attribute})) {
            if (count($this->{$attribute}) < self::MIN_FILES_SLIDER) {
                $this->addError($attribute, Yii::t('common', 'Minimum files is {count}.', [
                    'count' => self::MIN_FILES_SLIDER
                ]));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', 'Title'),
            'body' => Yii::t('common', 'Body'),
            'view' => Yii::t('common', 'Article View'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
            'category_id' => Yii::t('common', 'Category'),
            'status' => Yii::t('common', 'Published'),
            'published_at' => Yii::t('common', 'Published At'),
            'created_by' => Yii::t('common', 'Author'),
            'updated_by' => Yii::t('common', 'Updater'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'short_description' => Yii::t('common', 'Short Description'),
            'projects' => Yii::t('common', 'Projects'),
            'partners' => Yii::t('common', 'Partners'),
            'attachments' => Yii::t('common', 'Attachments'),
            'about_us' => Yii::t('common', 'About Us'),
            'about_us_thumbnail' => Yii::t('common', 'About Us Thumbnail'),
            'image_before' => Yii::t('common', 'Comparative Image Before'),
            'image_after' => Yii::t('common', 'Comparative Image After'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachment::class, ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticlePartners()
    {
        return $this->hasMany(ArticlePartner::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['id' => 'partner_id'])->viaTable('{{%article_partner}}', ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectArticles()
    {
        return $this->hasMany(ProjectArticle::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenterArticles()
    {
        return $this->hasMany(HelpCenterArticle::className(), ['article_id' => 'id']);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('{{%project_article}}', ['article_id' => 'id']);
    }

    /**
     * @return void
     */
    public function select2Init()
    {
        $partners = $this->getPartners()->joinWith('translation')->all();
        $this->partnersTexts = ArrayHelper::getColumn($partners, 'name');
        // Заполним выбранные ID партнёров для Select2
        $this->partners = ArrayHelper::getColumn($partners, 'id');

        $projects = $this->getProjects()->joinWith('translation')->all();
        $this->projectsTexts = ArrayHelper::getColumn($projects, 'title');
        // Заполним выбранные ID проектов для Select2
        $this->projects = ArrayHelper::getColumn($projects, 'id');
    }
    public function getArticlelang($lang)
    {
        $result = Yii::$app->db->createCommand('SELECT title, short_description FROM article_lang WHERE article_id=:id AND language=:lang')
            ->bindValue(':id', $this->id)
            ->bindValue(':lang', $lang)
            ->queryOne();
        return $result;
    }
}
