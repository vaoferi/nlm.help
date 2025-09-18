<?php

use dosamigos\tinymce\TinyMce;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\bootstrap\ActiveForm */
$model->select2Init();

?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you leave this field empty, the slug will be generated automatically'))
        ->textInput(['maxlength' => true]) ?>

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
            <?php echo $form->field($model, 'short_description'.$lng)->textarea()->label(Yii::t('common', 'Short Description').' '.$lang); ?>

             <?php /* echo $form->field($model, 'description'.$lng)->widget(
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

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <?php echo $form->field($model, 'is_finished')->checkbox() ?>

    <?php echo $form->field($model, 'required_amount')->textInput() ?>

    <?php echo $form->field($model, 'due_date')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATE
    ]) ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => uploadMaxSize(),
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]);
    ?>

    <?php echo $form->field($model, 'attachments')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'sortable' => true,
            'maxFileSize' => uploadMaxSize(),
            'maxNumberOfFiles' => 10,
        ])->label(Yii::t('backend', 'Reports'));
    ?>

    <?php
    $url = \yii\helpers\Url::to(['select-data/select-partners']);
    echo $form->field($model, 'partners')->widget(Select2::classname(), [
        'bsVersion' => '5',
        'initValueText' => $model->partnersTexts,
        'options' => ['placeholder' => Yii::t('backend', 'Search for partners ...'), 'multiple' => true],
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

    <?php echo $form->field($model, 'published_at')->widget(
        DateTimeWidget::class,
        [
            'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
        ]
    ) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
