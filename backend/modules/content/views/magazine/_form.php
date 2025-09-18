<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Magazine */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="magazine-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'title')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function(\yii\widgets\ActiveField $field) {
            return $field->textInput();
        }
    ]) ?>

    <?php echo $form->field($model, 'number')->input('number') ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => uploadMaxSize(),
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]);
    ?>

    <?= $form->field($model, 'alt')->widget(\common\widgets\MultiLanguageField::class, [
            'widgetOptions' => function(\yii\widgets\ActiveField $field) {
                return $field->textInput();
            }
    ]) ?>

    <?php echo $form->field($model, 'attachment')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => uploadMaxSize(),
            'acceptFileTypes' => new JsExpression('/(\.|\/)(pdf)$/i'),
        ]);
    ?>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
