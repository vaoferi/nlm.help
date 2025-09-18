<?php

namespace common\models;

use common\models\query\ArticleCategoryQuery;
use omgdef\multilingual\MultilingualBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\base\InvalidArgumentException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "article_category".
 *
 * @property integer         $id
 * @property string          $slug
 * @property string          $title
 * @property string          $description
 * @property string          $thumbnail_path
 * @property string          $thumbnail_base_url
 * @property integer         $status
 *
 * @property Article[]       $articles
 * @property ArticleCategory $parent
 */
class ArticleCategory extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT  = 0;

    public $thumbnail;

    public static function tableName()
    {
        return '{{%article_category}}';
    }

    /**
     * @return ArticleCategoryQuery
     */
    public static function find()
    {
        return new ArticleCategoryQuery(get_called_class());
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

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true,
            ],
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'article_category_id',
                'tableName' => "{{%article_category_lang}}",
                'attributes' => [
                    'title', 'description'
                ]
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url',
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thumbnail_path', 'thumbnail_base_url'], 'string'],
            ['thumbnail', 'safe'],
            [['title'], 'required'],
            ['description', 'string'],
            [['title'], 'string', 'max' => 512],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 1024],
            ['status', 'integer'],
//            ['parent_id', 'exist', 'targetClass' => ArticleCategory::class, 'targetAttribute' => 'id'],
        ];
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
            'parent_id' => Yii::t('common', 'Parent Category'),
            'status' => Yii::t('common', 'Active'),
            'description' => Yii::t('common', 'Description'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasMany(ArticleCategory::class, ['id' => 'parent_id']);
    }

    /**
     * @return array
     */
    public static function getNavCategories()
    {
        $categories = self::find()
            ->active()
            ->joinWith('translation')
            ->orderBy(['{{%article_category_lang}}.title' => SORT_ASC])
            ->all();
        return ArrayHelper::getColumn($categories, function(self $model) {
            return ['label' => $model->title, 'url' => ['article/category', 'slug' => $model->slug]];
        });
    }
}
