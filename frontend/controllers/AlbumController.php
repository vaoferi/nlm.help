<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace frontend\controllers;


use common\models\PhotoAlbum;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AlbumController extends Controller
{
    public function actionIndex()
    {
        $albumQuery = PhotoAlbum::find()
            ->active()
            ->withoutEmptyLang('title')
            ->with('photos')
            ->with('translation')
            ->orderBy(['created_at' => SORT_DESC]);

        $sliderAlbums = $albumQuery->limit(3)->all();

        $pagination = new Pagination([
            'totalCount' => $albumQuery->count(),

        ]);
        $albums = $albumQuery
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();

        return $this->render('index', [
            'models' => $albums,
            'pagination' => $pagination,
            'sliderAlbums' => $sliderAlbums
        ]);
    }

    public function actionView($id)
    {
        $model = PhotoAlbum::find()
            ->withoutEmptyLang('title')
            ->active()->andWhere(['{{%photo_album}}.id' => $id])->one();
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $this->render('view', [
            'model' => $model
        ]);
    }
}