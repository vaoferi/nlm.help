<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\payments\models\search\OrderProjectSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="order-project-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'amount') ?>

    <?php echo $form->field($model, 'comment') ?>

    <?php echo $form->field($model, 'full_name') ?>

    <?php echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'payment_system') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'project_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'transaction_id') ?>

    <?php // echo $form->field($model, 'amount_received') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
