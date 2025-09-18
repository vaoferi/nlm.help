<?php

namespace backend\modules\content\controllers;

use common\actions\Select2Action;
use common\models\Article;
use common\models\Partner;
use common\models\ProjectOrder;
use Yii;
use common\models\Project;
use backend\modules\content\models\search\ProjectSearch;
use yii\base\DynamicModel;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{

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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Project::find()->multilingual()->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Sort projects
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionSort()
    {
        $order = ProjectOrder::getOrder();
        $models = Project::find()->active()->specOrder($order)->all();
        $form = new DynamicModel(['orders']);
        $form->addRule('orders', 'string');
        $form->orders = implode(',', \yii\helpers\ArrayHelper::getColumn($models, 'id'));
        if ($form->load(Yii::$app->getRequest()->post()) && $form->validate()) {
            ProjectOrder::deleteAll(1);
            $form->orders = explode(',', $form->orders);
            $insert = [];
            foreach ($form->orders as $order => $project_id) {
                $order = $order + 1;
                $insert[] = [$order, $order, $project_id];
            }
            Yii::$app->getDb()->createCommand()->batchInsert(ProjectOrder::tableName(), ['id', 'order', 'project_id'], array_values($insert))->execute();
            return $this->redirect(['index']);
        }
        return $this->render('sort', [
            'models' => $models,
            'formModel' => $form
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
