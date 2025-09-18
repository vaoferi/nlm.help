<?php

namespace backend\modules\payments\controllers;

use Yii;
use common\models\OrderProject;
use backend\modules\payments\models\search\OrderProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderProjectController implements the CRUD actions for OrderProject model.
 */
class OrderProjectController extends Controller
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
     * Lists all OrderProject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'status' => SORT_DESC,
            'updated_at' => SORT_DESC,
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCash($id)
    {
        $model = $this->findModel($id);
        if ($model->status == $model::STATUS_PAID || !in_array($model->payment_system, ['cash', 'bank'])) {
            throw new NotFoundHttpException;
        }
        $model->amount_received = $model->amount;
        $model->status = $model::STATUS_PAID;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            $model->updateCounter($model->amount_received);
            return $this->redirect(['index']);
        }
        return $this->render('cach', [
            'model' => $model
        ]);
    }

    /**
     * Displays a single OrderProject model.
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
     * Creates a new OrderProject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderProject();

        if ($model->load(Yii::$app->request->post())) {
            $model->amount = $model->amount_received;
            $model->payment_system = 'cash';
            $model->status = $model::STATUS_PAID;
            if ($model->save()) {
                $model->updateCounter($model->amount_received);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing OrderProject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $orderProject = $this->findModel($id);
        $orderProject->updateCounter(-($orderProject->amount_received));
        $orderProject->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OrderProject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderProject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderProject::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
