<?php

namespace backend\modules\content\controllers;

use common\models\PartnerOrder;
use common\models\Project;
use Yii;
use common\models\Partner;
use backend\modules\content\models\search\PartnerSearch;
use yii\base\DynamicModel;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartnerController implements the CRUD actions for Partner model.
 */
class PartnerController extends Controller
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
     * Lists all Partner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Partner model.
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
     * Creates a new Partner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Partner();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Partner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Partner::find()->multilingual()->andWhere(['id' => $id])->one();
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
     * Sort partners
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionSort()
    {
        $order = PartnerOrder::getOrder();
        $models = Partner::find()->show()->active()->specOrder($order)->all();
        $form = new DynamicModel(['orders']);
        $form->addRule('orders', 'string');
        $form->orders = implode(',', \yii\helpers\ArrayHelper::getColumn($models, 'id'));
        if ($form->load(Yii::$app->getRequest()->post()) && $form->validate()) {
            PartnerOrder::deleteAll(1);
            $form->orders = explode(',', $form->orders);
            $insert = [];
            foreach ($form->orders as $order => $partner_id) {
                $order = $order + 1 ;
                $insert[] = [$order, $order, $partner_id];
            }
            Yii::$app->getDb()->createCommand()->batchInsert(PartnerOrder::tableName(), ['id', 'order', 'partner_id'], array_values($insert))->execute();
            return $this->redirect(['index']);
        }
        return $this->render('sort', [
            'models' => $models,
            'formModel' => $form
        ]);
    }

    /**
     * Deletes an existing Partner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.d
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Partner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Partner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partner::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
