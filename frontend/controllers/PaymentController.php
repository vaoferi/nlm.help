<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace frontend\controllers;


use common\commands\PaymentCommand;
use common\models\OrderCategory;
use common\models\OrderProject;
use common\models\OrderService;
use rexit\liqpay\LiqPayAction;
use Yii;
use yii\helpers\Json;
use yii\mutex\FileMutex;
use yii\web\NotFoundHttpException;

class PaymentController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'liqpay-ipn' => [
                'class' => LiqPayAction::class,
                'public_key' => Yii::$app->liqPay->public_key,
                'private_key' => Yii::$app->liqPay->private_key,
                'responseClass' => \common\components\payment\liqpay\LiqPayResponse::class
            ]

        ];
    }

    public function beforeAction($action)
    {
        if ($action instanceof LiqPayAction || $action->id == 'ipn') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionPaypal($sign)
    {
        $data = $this->getDataFromSign($sign);
        $order_id = $data['order_id'];
        $type = $data['type'];
        if ($type === 'project') {
            $order = OrderProject::findOne($order_id);
        } elseif($type === 'category') {
            $order = OrderCategory::findOne($order_id);
        } elseif($type === 'service') {
            $order = OrderService::findOne($order_id);
        } else {
            throw new NotFoundHttpException;
        }
        if ($order === null || $order->status == $order::STATUS_PAID) {
            throw new NotFoundHttpException;
        }
        return $this->render('paypal',[
            'order' => $order
        ]);

    }

    /**
     * @param $sign
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCash($sign)
    {
        $data = $this->getDataFromSign($sign);
        $order_id = $data['order_id'];
        $type = $data['type'];
        if ($type === 'project') {
            $order = OrderProject::findOne($order_id);
        } elseif($type === 'category') {
            $order = OrderCategory::findOne($order_id);
        } elseif($type === 'service') {
            $order = OrderService::findOne($order_id);
        } else {
            throw new NotFoundHttpException;
        }
        if ($order === null || $order->status == $order::STATUS_PAID) {
            throw new NotFoundHttpException;
        }
        return $this->render('cash', [
            'order' => $order
        ]);
    }

    /**
     * @param $sign
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionBank($sign)
    {
        $data = $this->getDataFromSign($sign);
        $order_id = $data['order_id'];
        $type = $data['type'];
        if ($type === 'project') {
            $order = OrderProject::findOne($order_id);
        } elseif($type === 'category') {
            $order = OrderCategory::findOne($order_id);
        } elseif($type === 'service') {
            $order = OrderService::findOne($order_id);
        } else {
            throw new NotFoundHttpException;
        }

        if ($order === null || $order->status == $order::STATUS_PAID) {
            throw new NotFoundHttpException;
        }
        return $this->render('bank', [
            'order' => $order
        ]);
    }

    /**
     * @param $sign
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLiqpay($sign)
    {
        $data = $this->getDataFromSign($sign);
        $order_id = $data['order_id'];
        $type = $data['type'];
        if ($type === 'project') {
            $order = OrderProject::findOne($order_id);
        } elseif($type === 'category') {
            $order = OrderCategory::findOne($order_id);
        } elseif($type === 'service') {
            $order = OrderService::findOne($order_id);
        } else {
            throw new NotFoundHttpException;
        }
        if ($order === null || $order->status == $order::STATUS_PAID) {
            throw new NotFoundHttpException;
        }
        return $this->render('liqpay', [
            'order' => $order
        ]);
    }

    /**
     * @param $sign
     * @return false|mixed|string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    protected function getDataFromSign($sign)
    {
        $data = Yii::$app->security->validateData($sign, Yii::$app->params['signKey']);
        if ($data === false) {
            throw new NotFoundHttpException;
        }
        $data = Json::decode($data);
        return $data;
    }

    public function actionIpn()
    {
        Yii::error(file_get_contents('php://input'));
        Yii::error(Yii::$app->getRequest()->getHeaders());
    }
}