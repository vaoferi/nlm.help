<?php

namespace common\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use omgdef\multilingual\MultilingualBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%partner}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property int $status 0 => not active, 1 => active
 * @property string $due_date
 * @property int $show_status 0 => not show, 1 => show
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property ArticlePartner[] $articlePartners
 * @property Article[] $articles
 * @property User $createdBy
 * @property User $updatedBy
 * @property PartnerOrder[] $partnerOrders
 * @property PartnerProject[] $partnerProjects
 * @property Project[] $projects
 */
class Partner extends \yii\db\ActiveRecord
{
    public $thumbnail;

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 1;

    //select2 fields
    public $projectsTexts;
    public $articlesTexts;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%partner}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            'upload_thumb' => [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url',
            ],
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'partner_id',
                'tableName' => "{{%partner_lang}}",
                'attributes' => [
                    'name', 'description',
                ]
            ],
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [
                    'projects',
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
            [['projects', 'articles'], 'safe'],
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['status', 'show_status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['due_date'], 'safe'],
            [['name', 'url'], 'string', 'max' => 512],
            [['thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['thumbnail'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'url' => Yii::t('common', 'Url'),
            'status' => Yii::t('common', 'Is Partner'),
            'due_date' => Yii::t('common', 'Due Date'),
            'show_status' => Yii::t('common', 'Show Status'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
            'projects' => Yii::t('common', 'Projects'),
            'articles' => Yii::t('common', 'Articles'),
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
     * {@inheritdoc}
     * @return \common\models\query\PartnerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PartnerQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticlePartners()
    {
        return $this->hasMany(ArticlePartner::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('{{%article_partner}}', ['partner_id' => 'id']);
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
    public function getPartnerOrders()
    {
        return $this->hasMany(PartnerOrder::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerProjects()
    {
        return $this->hasMany(PartnerProject::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('{{%partner_project}}', ['partner_id' => 'id']);
    }

    /**
     * @return void
     */
    public function select2Init()
    {
        $projects = $this->getProjects()->joinWith('translation')->all();
        $this->projectsTexts = ArrayHelper::getColumn($projects, 'title');

        $articles = $this->getArticles()->joinWith('translation')->all();
        $this->articlesTexts = ArrayHelper::getColumn($articles, 'title');
    }
}
