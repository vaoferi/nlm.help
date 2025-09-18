<?php

namespace backend\modules\payments\controllers;

use Yii;
use common\models\OrderCategory;
use backend\modules\payments\models\search\OrderCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderCategoryController implements the CRUD actions for OrderCategory model.
 */
class OrderCategoryController extends Controller
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
     * Lists all OrderCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderCategorySearch();
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
            return $this->redirect(['index']);
        }
        return $this->render('cach', [
            'model' => $model
        ]);
    }

    /**
     * Displays a single OrderCategory model.
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
     * Creates a new OrderCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderCategory();

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
     * Deletes an existing OrderCategory model.
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
     * Finds the OrderCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderCategory::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
