<?php

namespace backend\modules\content\controllers;

use backend\modules\content\models\search\ArticleSearch;
use common\actions\Select2Action;
use common\models\Article;
use common\models\ArticleCategory;
use common\models\Partner;
use common\models\Project;
use common\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    use FormAjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\base\ExitException
     */
    public function actionCreate()
    {
        $article = new Article();

        $this->performAjaxValidation($article);

        if ($article->load(Yii::$app->request->post()) && $article->save()) {
            return $this->redirect(['index']);
        }

        // Preload full lists for dropdowns (no typing required)
        $partners = Partner::find()->joinWith('translation')->orderBy(['partner_lang.name' => SORT_ASC])->all();
        $projects = Project::find()->joinWith('translation')->orderBy(['project_lang.title' => SORT_ASC])->all();
        return $this->render('create', [
            'model' => $article,
            'categories' => ArticleCategory::find()->active()->all(),
            'partnersList' => \yii\helpers\ArrayHelper::map($partners, 'id', 'name'),
            'projectsList' => \yii\helpers\ArrayHelper::map($projects, 'id', 'title'),
        ]);
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws \yii\base\ExitException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $article = Article::find()->multilingual()->andWhere(['id' => $id])->one();
        if ($article === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->performAjaxValidation($article);
        if ($article->load(Yii::$app->request->post()) && $article->save()) {
            return $this->redirect(['index']);
        }
        $partners = Partner::find()->joinWith('translation')->orderBy(['partner_lang.name' => SORT_ASC])->all();
        $projects = Project::find()->joinWith('translation')->orderBy(['project_lang.title' => SORT_ASC])->all();
        return $this->render('update', [
            'model' => $article,
            'categories' => ArticleCategory::find()->active()->all(),
            'partnersList' => \yii\helpers\ArrayHelper::map($partners, 'id', 'name'),
            'projectsList' => \yii\helpers\ArrayHelper::map($projects, 'id', 'title'),
        ]);
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');

    }

}
