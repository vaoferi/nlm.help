<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\SliderSertificat */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-3">
            <?php echo $form->field($model, 'status')->checkbox() ?>
        </div>
        <div class="col-md-3">
            <?php echo $form->field($model, 'order')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'button_url')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <ul class="nav nav-tabs" role="tablist">
        <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
            <?php $isactive = ($code === \Yii::$app->language)?'active':''; ?>
            <li class="<?= $isactive ?>">
                <a data-bs-toggle="tab" href="#<?= $code ?>" role="tab"><?= $lang ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Вкладка панели -->
    <div class="tab-content">
        <?php $defaultLang = Yii::$app->params['defaultLanguage']; ?>
        <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
            <?php $lng = ($code === $defaultLang)?'':'_'.$code; ?>
            <div class="tab-pane <?= ($code === \Yii::$app->language)?'active':'' ?>" id="<?= $code ?>" role="tabpanel">
                <?php echo $form->field($model, 'title'.$lng)->textInput(['maxlength' => true,'required'=>true])->label(Yii::t('common', 'Title').' '.$lang); ?>
                <?php echo $form->field($model, 'text'.$lng)->textarea(['rows' => 5])->label(Yii::t('common', 'Text').' '.$lang); ?>
                <?php echo $form->field($model, 'button_text'.$lng)->textInput(['maxlength' => true,'required'=>true])->label(Yii::t('common', 'Button text').' '.$lang); ?>


            </div>
        <?php endforeach; ?>
    </div>
    <hr>

    <?php /* echo $form->field($model, 'title')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function (\yii\widgets\ActiveField $field) {
            return $field->textInput(['maxlength' => true]);
        }
    ]) */ ?>

    <?php /* echo $form->field($model, 'text')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function (\yii\widgets\ActiveField $field) {
            return $field->textarea(['rows' => 5]);
        }
    ]) ?>

    <?php echo $form->field($model, 'button_text')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function (\yii\widgets\ActiveField $field) {
            return $field->textInput(['maxlength' => true]);
        }
    ])  */?>

    <?php echo $form->field($model, 'image')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => uploadMaxSize(),
            'acceptFileTypes' => new JsExpression('/(\.|\/)(jpe?g|png)$/i'),
        ]);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
