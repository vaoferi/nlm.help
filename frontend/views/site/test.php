<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
$model = new \rexit\liqpay\PaymentModel([
    'public_key' => 'i93381294',
    'private_key' => 'Rk9dJXEILfeRG0BR1SSsJ34Lf5nzwlNj28DDzaSr',
    'language' => 'uk',
    'order_id' => (string)time(),
    'amount' => 1,
    'currency' => 'UAH',
    'description' => 'Test payment',
    'action' => \rexit\liqpay\PaymentModel::ACTION_PAY,
    'sandbox' => 1,
    'server_url' => \yii\helpers\Url::to(['/site/liqpay'], 'https')
]);
echo \rexit\liqpay\LiqPayWidget::widget([
        'model' => $model
])
?>
<!--<div id='liqpay_checkout'></div>-->
<!--<script>-->
<!--    window.LiqPayCheckoutCallback = function() {-->
<!--        LiqPayCheckout.init({-->
<!--            data:'eyJhY3Rpb24iOiJwYXlkb25hdGUiLCJhbW91bnQiOiIxIiwiY3VycmVuY3kiOiJVU0QiLCJkZXNjcmlwdGlvbiI6ImRlc2NyaXB0aW9uIHRleHQiLCJvcmRlcl9pZCI6Im9yZGVyX2lkXzEiLCJ2ZXJzaW9uIjoiMyIsInNhbmRib3giOjEsInB1YmxpY19rZXkiOiJpOTMzODEyOTQifQ==',-->
<!--            signature: 'ieckkvewmFk0xGA8C/JPCvnzBKA=',-->
<!--            embedTo: '#liqpay_checkout',-->
<!--            mode: 'embed' // embed || popup,-->
<!--        }).on('liqpay.callback', function(data){-->
<!--            console.log(data.status);-->
<!--            console.log(data);-->
<!--        }).on('liqpay.ready', function(data){-->
<!--            // ready-->
<!--        }).on('liqpay.close', function(data){-->
<!--            // close-->
<!--        });-->
<!--    };-->
<!--</script>-->
