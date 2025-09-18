<?php

namespace backend\modules\content\controllers;

use common\base\MultiModel;
use common\models\Photo;
use Yii;
use common\models\PhotoAlbum;
use backend\modules\content\models\search\PhotoAlbumSearch;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhotoAlbumController implements the CRUD actions for PhotoAlbum model.
 */
class PhotoAlbumController extends Controller
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
     * Lists all PhotoAlbum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhotoAlbumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PhotoAlbum model.
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
     * Creates a new PhotoAlbum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PhotoAlbum();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([!empty($model->photos) ? 'update-photos' : 'view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PhotoAlbum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = PhotoAlbum::find()->multilingual()->andWhere(['id' => $id])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([!empty($model->photos) ? 'update-photos' : 'view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PhotoAlbum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\db\Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdatePhotos($id)
    {
        $photos = Photo::find()->where(['photo_album_id' => $id])->multilingual()->orderBy(['order' => SORT_ASC])->all();
        if (empty($photos)) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->getRequest()->isPost) {
            $oldIDs = ArrayHelper::map($photos, 'id', 'id');
            /* @var $photos Photo[] */
            $photos = MultiModel::createMultiple(Photo::classname(), $photos);
            Model::loadMultiple($photos, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($photos, 'id', 'id')));

            $valid = Model::validateMultiple($photos);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if (! empty($deletedIDs)) {
                        Photo::deleteAll(['id' => $deletedIDs]);
                    }
                    foreach ($photos as $photo) {
                        if (! ($flag = $photo->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('update-photos', [
           'photos' => $photos
        ]);
    }

    /**
     * Deletes an existing PhotoAlbum model.
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
     * Finds the PhotoAlbum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhotoAlbum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhotoAlbum::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
