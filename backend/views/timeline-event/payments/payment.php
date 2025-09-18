<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */
$url = [];
if ($model->data['order_id']) {
    $orderData = explode("_", $model->data['order_id']);
    if (count($orderData) === 2) {
        $orderType = array_shift($orderData);
        $orderId = array_shift($orderData);
        if ($orderType == 'project') {
            $url = ['/payments/order-project/view', 'id' => $orderId];
        } elseif ($orderType == 'category') {
            $url = ['/payments/order-category/view', 'id' => $orderId];
        } elseif ($orderType == 'service') {
            $url = ['/payments/order-service/view', 'id' => $orderId];
        }
    }
}
?>
<div class="timeline-item">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    </span>

    <h3 class="timeline-header">
        <?php echo Yii::t('backend', 'Payment received!') ?>
    </h3>

    <div class="timeline-body">
        <?php echo Yii::t('backend', 'New payment from ({identity}) was received at {created_at} amount: {amount}', [
            'identity' => $model->data['full_name'],
            'created_at' => Yii::$app->formatter->asDatetime($model->data['created_at']),
            'amount' => $model->data['amount']
        ]) ?>
    </div>

    <div class="timeline-footer">
        <?php echo \yii\helpers\Html::a(
            Yii::t('backend', 'View'),
            $url,
            ['class' => 'btn btn-success btn-sm']
        ) ?>
    </div>
</div>