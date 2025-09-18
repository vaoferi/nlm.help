<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 02.01.2022
 * Time: 11:05
 */

namespace frontend\controllers;

use common\models\Smi;
use frontend\models\search\SmiSearch;

use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;



class SmiController  extends Controller
{

    public function actionIndex()
    {

        $request = Yii::$app->request;
        $searchModel = new SmiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider  -> pagination -> defaultPageSize = 16;
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC],
        ];

        $paginationQuery = clone $dataProvider;
        $pages = new Pagination(
            [
                'defaultPageSize' => 16,
                'pageSizeLimit' => false,
                'forcePageParam' => false,
                'totalCount' => $paginationQuery->getTotalCount(),
            ]
        );

        if (!is_null($request->get('page'))) {
            $this->view->registerMetaTag(['name' => 'robots', 'content' => 'noindex,nofollow']);
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ]);

    }

}