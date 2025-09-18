<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;

class LanguageController extends Controller
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

    public function actionSet(string $lang, string $return = null): Response
    {
        $available = array_keys(Yii::$app->params['availableLocales'] ?? []);
        if (!in_array($lang, $available, true)) {
            $lang = Yii::$app->language;
        }
        Yii::$app->response->cookies->add(new Cookie([
            'name' => '_locale',
            'value' => $lang,
            'httpOnly' => true,
            'expire' => time() + 3600 * 24 * 365,
            'path' => '/',
        ]));

        $url = $return ?: (Yii::$app->request->referrer ?: ['/']);
        return $this->redirect($url);
    }
}

