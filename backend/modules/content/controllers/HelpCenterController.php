<?php

namespace backend\modules\content\controllers;

use common\models\HelpCenterService;
use Yii;
use common\models\HelpCenter;
use backend\modules\content\models\search\HelpCenterSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HelpCenterController implements the CRUD actions for HelpCenter model.
 */
class HelpCenterController extends Controller
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
     * Lists all HelpCenter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HelpCenterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HelpCenter model.
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
     * Creates a new HelpCenter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HelpCenter();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($model->serviceNames as $name) {
                $service = new HelpCenterService();
                $service->service_name = $name;
                $model->link('helpCenterServices', $service);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HelpCenter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = HelpCenter::find()->multilingual()->andWhere(['id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->serviceNames = ArrayHelper::getColumn($model->helpCenterServices, 'service_name');
        $checkOldNames = ArrayHelper::map($model->helpCenterServices, 'service_name', 'service_name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!is_array($model->serviceNames)) {
                $model->serviceNames = [];
                $delete = $checkOldNames;
            } else {
                $delete = array_diff($checkOldNames, $model->serviceNames);
            }
            if ($delete) {
                HelpCenterService::deleteAll(['service_name' => $delete, 'help_center_id' => $id]);
            }
            foreach ($model->serviceNames as $name) {
                if (!empty($checkOldNames[$name])) {
                    continue;
                }
                $service = new HelpCenterService();
                $service->service_name = $name;
                $model->link('helpCenterServices', $service);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HelpCenter model.
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
     * Finds the HelpCenter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HelpCenter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HelpCenter::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
