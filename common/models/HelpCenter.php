<?php

namespace common\models;

use common\dto\HelpCenterDTO;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualTrait;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%help_center}}".
 *
 * @property int $id
 * @property string $place_name
 * @property string $name
 * @property string $description
 * @property string $contacts
 * @property string $thumbnail_path
 * @property string $thumbnail_base_url
 *
 * @property HelpCenterArticle[] $helpCenterArticles
 * @property Article[] $articles
 * @property Project[] $projects
 * @property HelpCenterLang[] $helpCenterLangs
 * @property HelpCenterProject[] $helpCenterProjects
 * @property HelpCenterService[] $helpCenterServices
 */
class HelpCenter extends \yii\db\ActiveRecord
{
    //select2 fields
    public $projectsTexts;
    public $articlesTexts;
    public $servicesTexts;
    public $serviceNames;
    public $thumbnail;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_center}}';
    }

    public function behaviors()
    {
        return [
            'multi_language' => [
                'class' => MultilingualBehavior::className(),
                'languages' => array_keys(getLanguages()),
                'defaultLanguage' => getDefaultLanguage(),
                'langForeignKey' => 'help_center_id',
                'tableName' => "{{%help_center_lang}}",
                'attributes' => [
                    'name', 'description', 'contacts'
                ]
            ],
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [
                    'projects',
                    'articles',
                ],
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['serviceNames', 'required'],
            [['projects', 'articles', 'helpCenterServices', 'serviceNames'], 'safe'],
            ['place_name', 'in', 'range' => array_keys(self::getPlaceNames())],
            [['place_name', 'name'], 'string', 'max' => 255],
            [['description', 'contacts'], 'string'],
            [['place_name', 'name'], 'required'],
            [['thumbnail_path', 'thumbnail_base_url'], 'string', 'max' => 512],
            ['thumbnail', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'place_name' => Yii::t('common', 'Place Name'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'contacts' => Yii::t('common', 'Contacts'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
            'projects' => Yii::t('common', 'Projects'),
            'articles' => Yii::t('common', 'Articles'),
            'serviceNames' => Yii::t('common', 'Services'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenterArticles()
    {
        return $this->hasMany(HelpCenterArticle::className(), ['help_center_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenterLangs()
    {
        return $this->hasMany(HelpCenterLang::className(), ['help_center_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenterProjects()
    {
        return $this->hasMany(HelpCenterProject::className(), ['help_center_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenterServices()
    {
        return $this->hasMany(HelpCenterService::className(), ['help_center_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('{{%help_center_project}}', ['help_center_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('{{%help_center_article}}', ['help_center_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getPlaceNames()
    {
        return [
            'odesa' => Yii::t('common', 'Odesa'),
            'ochakov' => Yii::t('common', 'Ochakov'),
            'kyiv' => Yii::t('common', 'Kyiv'),
            'dnipro' => Yii::t('common', 'Dnipro'),
            'izmail' => Yii::t('common', 'Izmail'),
            'artsyz' => Yii::t('common', 'Artsyz'),
            'tarutino' => Yii::t('common', 'Tarutino'),
            'berezino' => Yii::t('common', 'Berezino'),
            'zaporizhzhia' => Yii::t('common', 'Zaporizhzhia'),
            'pavlograd' => Yii::t('common', 'Pavlograd'),
            'cherkasy-zagorodyshshe' => Yii::t('common', 'Cherkasy (Zagorodyshshe)'),
            'cherkasy-staryi-kovrai' => Yii::t('common', 'Cherkasy (Staryi Kovrai)'),
            'cherkasy' => Yii::t('common', 'Cherkasy'),
            'poltava' => Yii::t('common', 'Poltava'),
            'vinnytsia' => Yii::t('common', 'Vinnytsia'),
            'tatarbunary' => Yii::t('common', 'Tatarbunary'),
            'ordesa-velykyi-dalnyk' => Yii::t('common', 'Odessa (Velykyi Dal\'nyk)'),
            'odessa-krasnosilka' => Yii::t('common', 'Odessa (Krasnosilka)')
        ];
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

        $this->servicesTexts = array_values(HelpCenterService::getServices());
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public static function createJson(array $models)
    {
        $result = [];
        foreach ($models as $model) {
            $result[] = new HelpCenterDTO($model);
        }
        return Json::encode($result, JSON_PRETTY_PRINT);
    }
}
