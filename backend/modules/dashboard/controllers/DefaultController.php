<?php

namespace backend\modules\dashboard\controllers;

use common\models\Article;
use common\models\Video;
use common\models\Testimonial;
use common\models\Partner;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $stats = [
            'articles' => (int) Article::find()->count(),
            'videos' => (int) Video::find()->count(),
            'testimonials' => (int) Testimonial::find()->count(),
            'partners' => (int) Partner::find()->count(),
        ];

        $latest = Article::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();

        return $this->render('index', [
            'stats' => $stats,
            'latest' => $latest,
        ]);
    }
}

