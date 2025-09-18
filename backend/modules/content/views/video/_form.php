<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\helpers\MultilingualHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <p>Обязятельно заполнение поля "Название" на всех языках !</p>

    <ul class="nav nav-tabs" role="tablist">
        <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
            <?php $isactive = ($code === \Yii::$app->language)?'active':''; ?>
            <li class="nav-item <?= $isactive ?>">
                <a class="nav-link <?= $isactive ?>" data-bs-toggle="tab" href="#<?= $code ?>" role="tab"><?= $lang ?></a>
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

                <?php 
/* echo $form->field($model, 'description'.$lng)->widget(
                    \yii\imperavi\Widget::class,
                    [
                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                        'options' => [
                            'convertVideoLinks' => false,
                            'minHeight' => 400,
//                        'maxHeight' => 400,
                            //'buttonSource' => true,
                            'convertDivs' => false,
                            'removeEmptyTags' => true,
                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                        ],
                    ]
                )->label(Yii::t('common', 'Description').' '.$lang); 
*/
                ?>

                <?php echo $form->field($model, 'embed_code'.$lng)->textInput(['maxlength' => true,'required'=>false])->label(Yii::t('common', 'Video').' '.$lang); ?>
                <?php if (!$model->isNewRecord ) {
                    $vid = MultilingualHelper::getFieldName('embed_code', $code);
                    echo $model->$vid;
                }
                ?>

            </div>
        <?php endforeach; ?>
    </div>
    <hr>

    <?php
    /*
    echo $form->field($model, 'title')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function (\yii\widgets\ActiveField $field) {
            return $field->textInput(['maxlength' => true]);
        }
    ]) ?>

    <?php echo $form->field($model, 'description')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function (\yii\widgets\ActiveField $field) {
            return $field->widget(
                \yii\imperavi\Widget::class,
                [
                    'plugins' => ['fullscreen', 'fontcolor', 'video'],
                    'options' => [
                        'convertVideoLinks' => false,
                        'minHeight' => 400,
                        'maxHeight' => 400,
                        'buttonSource' => true,
                        'convertDivs' => false,
                        'removeEmptyTags' => true,
                        'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                    ],
                ]
            );
        }
    ]) */ ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
