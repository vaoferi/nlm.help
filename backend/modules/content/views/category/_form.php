<?php

use dosamigos\tinymce\TinyMce;
use trntv\filekit\widget\Upload;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * @var $this       yii\web\View
 * @var $model      common\models\ArticleCategory
 * @var $categories common\models\ArticleCategory[]
 */

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]); ?>
<?= $form->errorSummary($model); ?>

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

<?php /* echo $form->field($model, 'title')->widget(\common\widgets\MultiLanguageField::class, [
    'widgetOptions' => function (\yii\widgets\ActiveField $field) {
        return $field->textInput(['maxlength' => 512]);
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

<?php echo $form->field($model, 'thumbnail')->widget(
    Upload::class,
    [
        'url' => ['/file/storage/upload'],
        'maxFileSize' => uploadMaxSize(),
        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
    ]);
?>

<?php echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you leave this field empty, the slug will be generated automatically'))
    ->textInput(['maxlength' => 1024]) ?>

<?php //echo $form->field($model, 'parent_id')->dropDownList($categories, ['prompt' => '']) ?>

<?php echo $form->field($model, 'status')->checkbox() ?>

<div class="form-group">
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
