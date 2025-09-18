<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use common\models\ArticleCategory;
use common\models\User;
use common\models\UserProfile;
use common\models\HelpCenter;
use common\models\Partner;
use common\models\Project;
use common\models\query\ArticleQuery;
use frontend\models\CategoryDonateForm;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    /**
     * @param int $about_us
     * @param int $partner
     * @param int $project
     * @param int $help_center
     * @return string
     */
    public function actionIndex($about_us = 0, $partner = 0, $project = 0, $help_center = 0)
    {
        $articlesQuery = Article::find()
            ->published()
            ->withoutEmptyLang('title')
            ->orderBy(['published_at' => SORT_DESC]);

        //articles for slider without filter.
        $sliderArticles = $articlesQuery->limit(3)->all();
        if ($about_us) {
            $articlesQuery->aboutUs();
        }
        //filter articles by get requests
        $this->filterArticles($articlesQuery);
        //@todo about us
        $pagination = new Pagination([
            'totalCount' => $articlesQuery->count()
        ]);
        $articles = $articlesQuery
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();

        $partnersFilters = Partner::find()
            ->active()->withoutEmptyLang('name')
            ->all();
        $projectsFilters = Project::find()
            ->active()
            ->withoutEmptyLang('title')
            ->all();
        $helpCentersFilters = HelpCenter::find()->withoutEmptyLang('name')
            ->all();
        return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination,
            'sliderArticles' => $sliderArticles,
            'about_us' => $about_us,
            'partner' => $partner,
            'project' => $project,
            'help_center' => $help_center,
            'partnersFilters' => ArrayHelper::map($partnersFilters, 'id', 'name'),
            'projectsFilters' => ArrayHelper::map($projectsFilters, 'id', 'title'),
            'helpCentersFilters' => ArrayHelper::map($helpCentersFilters, 'id', 'name'),
        ]);
    }

    /**
     * @param ArticleQuery $query
     */
    protected function filterArticles(ArticleQuery $query)
    {
        $filterPartner = Yii::$app->getRequest()->get('partner');
        $filterHelpCenter = Yii::$app->getRequest()->get('help_center');
        $filterProject = Yii::$app->getRequest()->get('project');
        if ($filterPartner || $filterProject || $filterHelpCenter) {
            if ((int)$filterPartner) {
                $query->byPartner((int)$filterPartner);
            }
            if ((int)$filterProject) {
                $query->byProject((int)$filterProject);
            }

            if ((int)$filterHelpCenter) {
                $query->byHelpCenter((int)$filterHelpCenter);
            }
        }
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Article::find()
            ->published()->andWhere(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }
        // If current language translation is missing, switch to 'nottranslate' view
        $currentLang = substr(Yii::$app->language, 0, 2);
        $langData = $model->getArticlelang($currentLang);
        if (empty($langData) || empty($langData['title'])) {
            $model->view = 'nottranslate';
        }
        $threeNews = Article::find()
            ->withoutEmptyLang('title')
            ->andWhere(['!=', '{{%article}}.id', $model->id])
            ->published()->limit(3)->orderBy(['published_at' => SORT_DESC])->all();

        $project = $model->projects ? $model->projects[0] : null;
        $viewFile = $model->view ?: 'view';
        return $this->render($viewFile, [
            'model' => $model,
            'threeNews' => $threeNews,
            'project' => $project
        ]);
    }

    public function actionCategory($slug)
    {
        $category = ArticleCategory::find()
            ->active()
            ->andWhere(['slug' => $slug])
            ->one();
        if ($category === null) {
            throw new NotFoundHttpException;
        }
        $articlesQuery = Article::find()
            ->published()
            ->withoutEmptyLang('title')
            ->limit(3)
            ->andWhere(['category_id' => $category->id])
            ->orderBy(['published_at' => SORT_DESC]);
        $pagination = new Pagination([
            'totalCount' => $articlesQuery->count(),
        ]);
        $articles = $articlesQuery->limit($pagination->limit)->offset($pagination->offset)->all();
        return $this->render('category', [
            'category' => $category,
            'articles' => $articles,
            'pagination' => $pagination
        ]);
    }

    public function actionDonate($id)
    {
        $category = ArticleCategory::find()
            ->withoutEmptyLang('title')
            ->active()->andWhere(['{{%article_category}}.id' => $id])->one();
        if ($category === null) {
            throw new NotFoundHttpException;
        }
        $model = new CategoryDonateForm();
        $model->payment_system = 'cash';
        $model->setCategory($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($order = $model->createOrder()) {
                $sign = Yii::$app->security->hashData(json_encode(['order_id' => $order->id, 'type' => 'category']), Yii::$app->params['signKey']);
                return $this->redirect(['payment/' . $model->payment_system, 'sign' => $sign]);
            }
        }
        return $this->render('donate', [
            'category' => $category,
            'model' => $model
        ]);
    }


    public function actionViewUser(string $slug)
    {
        $user = User::find()
            ->where(['slug' => $slug])
            ->one();
        if ($user === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('view-user', [
            'user' => $user,
            'currentLanguage' => \Yii::$app->language,
        ]);
    }

}
