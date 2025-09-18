<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 10.05.19
 * Time: 12:50
 */

use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
<p><?php echo Yii::t('backend', '1. You should to authenticate once and after changing password on Vkontakte.'); ?></p>
<?php echo Html::a(Yii::t('backend', 'Authenticate'), $url, ['class' => 'btn btn-success', 'target' => '_blank']) ?>

<div class="vk" style="margin-top: 15px">
    <p><?php echo Yii::t('backend', '2. Please paste access_token value from URL of new opened page (between "#access_token=" and "&expires_in") to input below and submit the form.') ?></p>
    <?php $form = ActiveForm::begin([
        'method' => 'POST',
        'action' => ['auth/vk'],
    ]) ?>

    <?php echo $form->field($model, 'token')->textInput(['maxlength' => true])->label(Yii::t('common', 'Token')); ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>