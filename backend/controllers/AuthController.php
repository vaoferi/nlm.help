<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace backend\controllers;


use common\models\TokenStorage;
use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionVk()
    {
        throw new \yii\web\NotFoundHttpException();
    }

    public function actionVk_old()
    {
        $oauth = new \VK\OAuth\VKOAuth();
        $client_id = Yii::$app->params['vk']['clientId'];
        $redirect_uri = Yii::$app->params['vk']['redirectUri'];
        $display = Yii::$app->params['vk']['display'];
        $scope = Yii::$app->params['vk']['scope'];;
        $state = Yii::$app->params['vk']['state'];

        $loginUrl = $oauth->getAuthorizeUrl(\VK\OAuth\VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $state, null);

        $model = new \yii\base\DynamicModel(['token']);
        $model->addRule(['token'], 'required')
            ->addRule('token', 'filter', ['filter' => 'trim'])
            ->addRule('token', 'string', ['max' => 500]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $tokenStorage = TokenStorage::findOne(['client' => TokenStorage::CLIENT_VK]);
            if ($tokenStorage === null) {
                $tokenStorage = new TokenStorage();
                $tokenStorage->client = TokenStorage::CLIENT_VK;
            }
            $tokenStorage->token = $model->token;

            if ($tokenStorage->save(false)) {
                Yii::$app->getSession()->setFlash('success', ['options' => ['class' => 'alert-success alert-dismissable'], 'body' => Yii::t('backend', 'User has just been successfully authenticated.')]);
                return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('error', ['options' => ['class' => 'alert-error alert-dismissable'], 'body' => Yii::t('backend', 'Token wasn\'t saved.')]);
            }
        }

        return $this->render('vk', [
            'url' => $loginUrl,
            'model' => $model,
        ]);
    }

    /**
     * @return string
     * @throws FacebookSDKException
     */
    public function actionFb()
    {
        $fb = new Facebook([
            'app_id' => Yii::$app->params['fb']['appId'],
            'app_secret' => Yii::$app->params['fb']['secretKey'],
            'default_graph_version' => Yii::$app->params['fb']['version'],
        ]);

        $helper = $fb->getRedirectLoginHelper();
        //add redirectUrl to the settings of your app to 'Действительные URI перенаправления для OAuth'.
        $permissions = Yii::$app->params['fb']['permissions'];
        $loginUrl = $helper->getLoginUrl(Yii::$app->params['fb']['redirectUri'], $permissions);

        return $this->render('fb', [
            'url' => $loginUrl,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws FacebookSDKException
     */
    public function actionFbCallback()
    {
        $fb = new Facebook([
            'app_id' => Yii::$app->params['fb']['appId'],
            'app_secret' => Yii::$app->params['fb']['secretKey'],
            'default_graph_version' => Yii::$app->params['fb']['version'],
        ]);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
            if ($accessToken instanceof AccessToken && $accessToken->getValue()) {
                $oAuth2Client = $fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                // Set default access token to be used in script
                $fb->setDefaultAccessToken($longLivedAccessToken);
                $tokenStorage = TokenStorage::findOne(['client' => TokenStorage::CLIENT_FB]);
                if ($tokenStorage === null) {
                    $tokenStorage = new TokenStorage();
                    $tokenStorage->client = TokenStorage::CLIENT_FB;
                }
                $tokenStorage->token = $longLivedAccessToken->getValue();
                if ($longLivedAccessToken->getExpiresAt() !== null) {
                    $tokenStorage->expire_at = ($longLivedAccessToken->getExpiresAt())->getTimestamp();
                }

                if ($tokenStorage->save()) {
                    Yii::$app->getSession()->setFlash('success', ['options' => ['class' => 'alert-success alert-dismissable'], 'body' => Yii::t('backend', 'User has just been successfully authenticated.')]);
                } else {
                    Yii::$app->getSession()->setFlash('error', ['options' => ['class' => 'alert-error alert-dismissable'], 'body' => Yii::t('backend', 'Token wasn\'t saved.')]);
                }
            } else {
                Yii::$app->getSession()->setFlash('error', ['options' => ['class' => 'alert-error alert-dismissable'], 'body' => Yii::t('backend', 'Token wasn\'t received.')]);
            }
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $this->redirect('fb');
    }

    public function actionOk()
    {
        throw new \yii\web\NotFoundHttpException();
    }

    public function actionOk_old()
    {
        $params = [
            'client_id' => Yii::$app->params['ok']['clientId'],
            'scope' => Yii::$app->params['ok']['scope'],
            'response_type' => Yii::$app->params['ok']['responseType'],
            'redirect_uri' => Yii::$app->params['ok']['redirectUri'],
            'layout' => Yii::$app->params['ok']['layout'],
            'state' => Yii::$app->params['ok']['state'],
        ];

        $query = http_build_query($params);
        $loginUrl = "https://connect.ok.ru/oauth/authorize?{$query}";

        return $this->render('ok', [
            'url' => $loginUrl,
        ]);
    }

    public function actionOkCallback()
    {
        throw new \yii\web\NotFoundHttpException();
    }

    public function actionOkCallback_old()
    {
        $model = new \yii\base\DynamicModel(['token']);
        $model->addRule(['token'], 'required')
            ->addRule('token', 'filter', ['filter' => 'trim'])
            ->addRule('token', 'string', ['max' => 500]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $tokenStorage = TokenStorage::findOne(['client' => TokenStorage::CLIENT_OK]);
            if ($tokenStorage === null) {
                $tokenStorage = new TokenStorage();
                $tokenStorage->client = TokenStorage::CLIENT_OK;
            }
            $tokenStorage->token = $model->token;
            $tokenStorage->expire_at = time() + TokenStorage::OK_LONG_TOKEN_EXPIRES_IN;
            if ($tokenStorage->save(false)) {
                Yii::$app->getSession()->setFlash('success', ['options' => ['class' => 'alert-success alert-dismissable'], 'body' => Yii::t('backend', 'User has just been successfully authenticated.')]);
                return $this->redirect('ok');
            } else {
                Yii::$app->getSession()->setFlash('error', ['options' => ['class' => 'alert-error alert-dismissable'], 'body' => Yii::t('backend', 'Token wasn\'t saved.')]);
            }
        }

        return $this->render('ok-token', [
            'model' => $model,
        ]);
    }

}