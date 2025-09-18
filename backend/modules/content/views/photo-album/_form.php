<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\PhotoAlbum */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="photo-album-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>


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
            </div>
        <?php endforeach; ?>
    </div>
    <hr>
    <?php /* echo $form->field($model, 'title')->widget(\common\widgets\MultiLanguageField::class, [
            'widgetOptions' => function(\yii\widgets\ActiveField $field) {
                return $field->textInput(['maxlength' => true]);
            }
    ]) */ ?>

    <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true])->hint(Yii::t('backend', 'If you leave this field empty, the slug will be generated automatically')) ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <?php echo $form->field($model, 'uploadPhotos')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'sortable' => true,
            'maxFileSize' => uploadMaxSize(),
            'maxNumberOfFiles' => 50,
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]);
    ?>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
