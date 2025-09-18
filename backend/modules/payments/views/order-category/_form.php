<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderCategory */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="order-project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'amount_received')->textInput() ?>

    <?php echo $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category_id')->widget(\kartik\select2\Select2::class,[
            'data' => \yii\helpers\ArrayHelper::map(\common\models\ArticleCategory::find()->active()->all(), 'id', 'title'),
    ]) ?>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
