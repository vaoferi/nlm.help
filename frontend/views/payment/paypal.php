<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
?>
<?= \rexit\paypal\PayPalWidget::widget([
    'client_id' => 'Ae5bKT8I989Vq1ti8HpWKQDdb_SN5m_3R6jUggFhFZDyDIWPMLSPBpzDwuNRq-pWT4lHcwktqByxcVHM',
    'currency' => 'USD',
    'amount' => $order->amount
])?>
