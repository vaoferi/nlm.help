<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 08.05.19
 * Time: 16:52
 */

use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?php echo Alert::widget([
        'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'body'),
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'options'),
    ]) ?>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <?php echo Alert::widget([
        'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('error'), 'body'),
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('error'), 'options'),
    ]) ?>
<?php endif; ?>
<p><?php echo Yii::t('backend', 'Token has to be received every 60 days or after changing password on Facebook.'); ?></p>
<?php echo Html::a(Yii::t('backend', 'Authenticate'), $url, ['class' => 'btn btn-success', 'target' => '_blank']) ?>
