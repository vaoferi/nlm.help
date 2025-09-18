<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Smi */
/* @var $form yii\widgets\ActiveForm
 * @var $categories common\models\CatalogSmi[]
 */
?>

<div class="smi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
        <?php $lng = ($lang === \Yii::$app->language)?'':'_'.$code; ?>
        <?php echo $form->field($model, 'preview'.$lng)->textInput(['maxlength' => true])->label(Yii::t('common', 'Preview').' '.$lang); ?>
    <?php endforeach; ?>

    <?php echo $form->field($model, 'cat_smi_id')->dropDownList(\yii\helpers\ArrayHelper::map(
        $categories,
        'id',
        'title'
    ), ['prompt' => 'выберите']) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('frontend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
