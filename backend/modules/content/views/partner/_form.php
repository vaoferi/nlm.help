<?php

use dosamigos\tinymce\TinyMce;
use common\widgets\MultiLanguageField;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\imperavi\Widget;
use yii\web\JsExpression;
use yii\widgets\ActiveField;

/* @var $this yii\web\View */
/* @var $model common\models\Partner */
/* @var $form yii\bootstrap\ActiveForm */
$model->select2Init();
?>

<div class="partner-form">

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

    <div class="tab-content">
        <?php $defaultLang = Yii::$app->params['defaultLanguage']; ?>
        <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
        <?php $lng = ($code === $defaultLang)?'':'_'.$code; ?>
            <div class="tab-pane <?= ($code === \Yii::$app->language)?'active':'' ?>" id="<?= $code ?>" role="tabpanel">
                <?php echo $form->field($model, 'name'.$lng)->textInput(['maxlength' => true,'required'=>true])->label(Yii::t('common', 'Title').' '.$lang); ?>

                <?php /* echo $form->field($model, 'description'.$lng)->widget(
                    \yii\imperavi\Widget::class,
                    [
                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                        'options' => [
                            'convertVideoLinks' => false,
                            'minHeight' => 400,
                            //'buttonSource' => true,
                            'convertDivs' => false,
                            'removeEmptyTags' => true,
                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                        ],
                    ]
                )->label(Yii::t('common', 'Description').' '.$lang); */
                $useTinymce = (Yii::$app->params['editor'] ?? 'redactor') === 'tinymce';
                if ($useTinymce) {
                    echo $form->field($model, 'description'.$lng)->widget(TinyMce::className(), [
                        'options' => ['rows' => 10],
                        'language' => 'ru',
                        'clientOptions' => [
                            'plugins' => [
                                'advlist autolink lists link charmap  print hr preview pagebreak',
                                'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                                'save insertdatetime media table contextmenu template paste image'
                            ],
                            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                        ]
                    ]);
                } else {
                    echo $form->field($model, 'description'.$lng)->widget(\yii\imperavi\Widget::class, [
                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                        'options' => [
                            'convertVideoLinks' => false,
                            'minHeight' => 400,
                            'removeEmptyTags' => true,
                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                        ],
                    ])->label(Yii::t('common', 'Description').' '.$lang);
                }

                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <hr>
        <?php /*
        echo $form->field($model, 'name')->widget(MultiLanguageField::class, [
        'widgetOptions' => function (ActiveField $field) {
            return $field->input('text');
        }
    ]) */ ?>


    <?php /* echo $form->field($model, 'description')->widget(MultiLanguageField::class, [
        'widgetOptions' => function (ActiveField $field) {
            return $field->widget(
                Widget::class,
                [
                    'plugins' => ['fullscreen', 'fontcolor', 'video'],
                    'options' => [
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

    <?php echo $form->field($model, 'url')->input('url') ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => uploadMaxSize(),
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]);
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <?php echo $form->field($model, 'due_date')->widget(DateControl::class, [
        'type' => DateControl::FORMAT_DATE
    ]) ?>
    <?php
    $url = \yii\helpers\Url::to(['select-data/select-projects']);
    echo $form->field($model, 'projects')->widget(Select2::classname(), [
        'bsVersion' => '5',
        'initValueText' => $model->projectsTexts,
        'options' => ['placeholder' => Yii::t('backend', 'Search for projects ...'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page || 1}; }')
            ]
        ],
    ]);
    ?>

    <?php
    $url = \yii\helpers\Url::to(['select-data/select-articles']);
    echo $form->field($model, 'articles')->widget(Select2::classname(), [
        'initValueText' => $model->articlesTexts,
        'options' => ['placeholder' => Yii::t('backend', 'Search for articles ...'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page || 1}; }')
            ]
        ],
    ]);
    ?>

    <?php echo $form->field($model, 'show_status')->checkbox() ?>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
