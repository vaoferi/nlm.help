<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\CatalogSmi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-smi-form">

    <?php $form = ActiveForm::begin(); ?>

        <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
            <?php $lng = ($lang === \Yii::$app->language)?'':'_'.$code; ?>
                <?php echo $form->field($model, 'title'.$lng)->textInput(['maxlength' => true])->label(Yii::t('common', 'Title').' '.$lang); ?>
        <?php endforeach; ?>

        <?php echo $form->field($model, 'image')->widget(
            Upload::class,
            [
                'url' => ['/file/storage/upload'],
                'maxFileSize' => uploadMaxSize(),
                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
            ]);
        ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
