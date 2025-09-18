<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $order null|\common\models\OrderProject */
?>
<section class="payment__cash">
    <h2><?= Yii::t('frontend', 'Thank you, {full_name}!', [
            'full_name' => $order->full_name
        ]) ?></h2>
    <p><?= Yii::t('frontend', 'We will contact you soon!') ?></p>
</section>