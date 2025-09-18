<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:20 AM
 */

namespace backend\controllers;

use backend\models\AccountForm;
use backend\models\LoginForm;
use common\models\UserSocialNetwork;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\Controller;

class SignInController extends Controller
{

    public $defaultAction = 'login';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'avatar-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::class
            ]
        ];
    }


    public function actionLogin()
    {
        // Use Hyper layout if enabled; fallback to base
        $this->layout = (env('ADMIN_THEME') === 'hyper') ? 'hyper' : 'base';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->userProfile;
        $usnFromDb = UserSocialNetwork::findAll(['user_id' => $model->user_id]);
        $usnFromDbBySn = ArrayHelper::index($usnFromDb,function ($model) {
            return $model->social_network;
        });

        $userSocialNetworks = [];
        $networks = array_keys(UserSocialNetwork::socialNetworks());
        foreach ($networks as $network) {
            if (!empty($usnFromDbBySn[$network])) {
                $userSocialNetworks[$network] = $usnFromDbBySn[$network];
            } else {
                $userSocialNetwork = new UserSocialNetwork();
                $userSocialNetwork->social_network = $network;
                $userSocialNetwork->user_id = Yii::$app->user->getId();
                $userSocialNetworks[$network] = $userSocialNetwork;
            }
        }
        $post = Yii::$app->request->post();

        if (!empty($post['UserProfile']) && !empty($post['UserSocialNetwork']) && $model->load($post)) {
            $isValid = $model->validate();
            $links = $post['UserSocialNetwork'];
            if ($isValid) {
                $networksForSave = [];
                $deleteIds = [];
                foreach ($links as $linkArr) {
                    if (isset($linkArr['social_network']) && $linkArr['social_network'] && isset($linkArr['link']) && !empty($userSocialNetworks[$linkArr['social_network']])) {
                        $tempNetwork = $linkArr['social_network'];
                        if ($linkArr['link']) {
                            /** @var UserSocialNetwork $userSocialNetworks[$temNetwork] */
                            $userSocialNetworks[$tempNetwork]->link = $linkArr['link'];
                            $isValid = $userSocialNetworks[$tempNetwork]->validate();
                            $networksForSave[] = $userSocialNetworks[$tempNetwork];
                        }
                        if (!$linkArr['link'] && ($userSocialNetworks[$tempNetwork]->id !== null)) {
                            $deleteIds[] = $userSocialNetworks[$tempNetwork]->id;
                        }
                    }
                }

                if ($isValid) {
                    $model->save(false);
                    foreach ($networksForSave as $networkForSave) {
                        $networkForSave->save(false);
                    }
                    Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-success'],
                        'body' => Yii::t('backend', 'Your profile has been successfully saved', [], $model->locale)
                    ]);
                    UserSocialNetwork::deleteAll(['id' => $deleteIds]);
                    return $this->refresh();
                }
            }
        }
        return $this->render('profile', [
            'model' => $model,
            'userSocialNetworks' => $userSocialNetworks,
        ]);
    }

    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->username = $user->username;
        $model->email = $user->email;
        if ($model->load($_POST) && $model->validate()) {
            $user->username = $model->username;
            $user->email = $model->email;
            if ($model->password) {
                $user->setPassword($model->password);
            }
            $user->save();
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('backend', 'Your account has been successfully saved')
            ]);
            return $this->refresh();
        }
        return $this->render('account', ['model' => $model]);
    }
}
