<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserController extends Controller
{
    public function actionView(string $slug)
    {
        if ($user = User::find()
            ->where(['slug' => $slug])
            ->one()) {
            return $this->render('view', [
                'user' => $user,
            ]);
        }
    }
}
