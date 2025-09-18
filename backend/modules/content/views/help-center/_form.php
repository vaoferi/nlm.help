<?php

use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\HelpCenter */
/* @var $form yii\bootstrap\ActiveForm */
$model->select2Init();
?>

<div class="help-center-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'place_name')->dropDownList(\common\models\HelpCenter::getPlaceNames(), [
            'prompt' => Yii::t('backend', 'Select place')
    ]) ?>


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
                <?php echo $form->field($model, 'name'.$lng)->textInput(['maxlength' => true,'required'=>true])->label(Yii::t('common', 'Title').' '.$lang); ?>

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
                )->label(Yii::t('common', 'Description').' '.$lang); ;
                ?>
                <?php echo $form->field($model, 'contacts'.$lng)->textarea(['rows' => 5])->label(Yii::t('common', 'Contacts').' '.$lang)->hint(Yii::t('backend', 'Use line by line syntax.'));  */
                $useTinymce = (Yii::$app->params['editor'] ?? 'redactor') === 'tinymce';
                if ($useTinymce) {
                    echo $form->field($model, 'description'.$lng)->widget(TinyMce::className(), [
                        'options' => ['rows' => 30],
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

    <?php /* echo $form->field($model, 'name')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function (\yii\widgets\ActiveField $field) {
            return $field->textInput();
        }
    ]) */ ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => uploadMaxSize(),
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]);
    ?>

    <?php /* echo $form->field($model, 'description')->widget(\common\widgets\MultiLanguageField::class, [
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

    <?php /* echo $form->field($model, 'contacts')->widget(\common\widgets\MultiLanguageField::class, [
        'widgetOptions' => function (\yii\widgets\ActiveField $field) {
            return $field->textarea(['rows' => 5])->hint(Yii::t('backend', 'Use line by line syntax.'));
        }
    ])  */ ?>

    <?= $form->field($model, 'serviceNames')->widget(Select2::classname(), [
        'bsVersion' => '5',
        'initValueText' => $model->servicesTexts,
        'options' => ['placeholder' => Yii::t('backend', 'Search for services ...'), 'multiple' => true],
        'data' => \common\models\HelpCenterService::getServices(),
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>


    <?php
    $url = \yii\helpers\Url::to(['select-data/select-projects']);
    echo $form->field($model, 'projects')->widget(Select2::classname(), [
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


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
