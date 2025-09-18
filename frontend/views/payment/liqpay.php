<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $order \common\models\OrderAbstract */
use \rexit\liqpay\PaymentModel;
use \rexit\liqpay\LiqPayWidget;
use yii;
use \yii\helpers\Url;

$model = new PaymentModel([
    'public_key' => 'i69391837367',
    'private_key' => '3GW5TmJjT95bB387Xx9ZweWTaV67f8jFHYi17i18',
    'language' => (Yii::$app->language ==='ru')?'ru':'en',
    'order_id' => implode("_", [
        $order->order_type,
        $order->id
    ]),
    'amount' => $order->amount,
//    'currency' => Yii::$app->formatter->currencyCode,
    'currency' => (Yii::$app->language ==='ru')?PaymentModel::CURRENCY_UAH:PaymentModel::CURRENCY_USD,
    'description' => Yii::t('frontend', 'Donate from: {name} #{number}', [
        'name' => $order->full_name,
        'number' => $order->id
    ]),
    'action' => PaymentModel::ACTION_PAY_DONATE,
    'sandbox' => YII_ENV_DEV ? '1' : '0',
    'server_url' => Url::to(['/payment/liqpay-ipn'], 'https')
]);
?>

<div class="liqpay-page">
    <?= LiqPayWidget::widget([
        'model' => $model
    ]);
    ?>
</div>
