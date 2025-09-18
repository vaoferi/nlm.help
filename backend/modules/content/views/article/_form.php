<?php

use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * @var $this       yii\web\View
 * @var $model      common\models\Article
 * @var $categories common\models\ArticleCategory[]
 */
$model->select2Init();
?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]) ?>
<?= $form->errorSummary($model); ?>

<ul class="nav nav-tabs" role="tablist">
    <?php $defaultLang = Yii::$app->params['defaultLanguage']; ?>
    <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
        <?php $isactive = ($code === \Yii::$app->language)?'active':''; ?>
        <li class="nav-item">
            <a class="nav-link <?= $isactive ?>" data-bs-toggle="tab" href="#<?= $code ?>" role="tab"><?= $lang ?></a>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Вкладка панели -->
<div class="tab-content">
    <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
        <?php $lng = ($code === $defaultLang)?'':'_'.$code; ?>
        <div class="tab-pane <?= ($code === \Yii::$app->language)?'active':'' ?>" id="<?= $code ?>" role="tabpanel">
            <?php echo $form->field($model, 'title'.$lng)->textInput(['maxlength' => true])->label(Yii::t('common', 'Title').' '.$lang); ?>
            <?php echo $form->field($model, 'short_description'.$lng)->textarea(['rows' => 6])->label(Yii::t('common', 'Short Description').' '.$lang); ?>

            <?php /* echo $form->field($model, 'body'.$lng)->widget(
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
            // Простое и надёжное поле ввода: обычный textarea увеличенного размера
            echo $form->field($model, 'body'.$lng)
                ->textarea(['rows' => 16])
                ->label(Yii::t('common', 'Description').' '.$lang);

            ?>

        </div>
    <?php endforeach; ?>
</div>
<hr>

<?php /* echo $form->field($model, 'title')->widget(\common\widgets\MultiLanguageField::class, [
    'widgetOptions' => function (\yii\widgets\ActiveField $field) {
        return $field->textInput(['maxlength' => true]);
    }
]) ?>
<?php echo $form->field($model, 'short_description')->widget(\common\widgets\MultiLanguageField::class, [
    'widgetOptions' => function (\yii\widgets\ActiveField $field) {
        return $field->textarea();
    }
]) */ ?>

<?php echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you leave this field empty, the slug will be generated automatically'))
    ->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
    $categories,
    'id',
    'title'
), ['prompt' => '']) ?>

<?php /* echo $form->field($model, 'body')->widget(\common\widgets\MultiLanguageField::class, [
    'widgetOptions' => function (\yii\widgets\ActiveField $field) {
        return $field->widget(
            \yii\imperavi\Widget::class,
            [
                'plugins' => ['fullscreen', 'fontcolor', 'video'],
                'options' => [
                    'minHeight' => 400,
                    'maxHeight' => 400,
                    'buttonSource' => true,
                    'convertVideoLinks' => false,
                    'convertDivs' => false,
                    'removeEmptyTags' => true,
                    'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                ],
            ]
        );
    }
])  */ ?>

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
        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
    ])->label(Yii::t('backend', 'Reports'));
?>

<?php //echo $form->field($model, 'view')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'status')->checkbox() ?>

<?php
// Use full dropdown without typing if list provided
if (isset($projectsList)) {
    echo $form->field($model, 'projects')->widget(Select2::classname(), [
        'bsVersion' => '5',
        'data' => $projectsList,
        'options' => ['placeholder' => Yii::t('backend', 'Проекты'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownAutoWidth' => true,
        ],
    ]);
} else {
    $url = \yii\helpers\Url::to(['select-data/select-projects']);
    echo $form->field($model, 'projects')->widget(Select2::classname(), [
        'bsVersion' => '5',
        'initValueText' => $model->projectsTexts,
        'options' => ['placeholder' => Yii::t('backend', 'Search for projects ...'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'dropdownAutoWidth' => true,
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term||"", page: params.page || 1}; }')
            ]
        ],
    ]);
}
?>

<?php
if (isset($partnersList)) {
    echo $form->field($model, 'partners')->widget(Select2::classname(), [
        'bsVersion' => '5',
        'data' => $partnersList,
        'options' => ['placeholder' => Yii::t('backend', 'Партнёры'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownAutoWidth' => true,
        ],
    ]);
} else {
    $url = \yii\helpers\Url::to(['select-data/select-partners']);
    echo $form->field($model, 'partners')->widget(Select2::classname(), [
        'bsVersion' => '5',
        'initValueText' => $model->partnersTexts,
        'options' => ['placeholder' => Yii::t('backend', 'Search for partners ...'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'dropdownAutoWidth' => true,
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term||"", page: params.page || 1}; }')
            ]
        ],
    ]);
}
?>

<?= $form->field($model, 'about_us')->checkbox() ?>

<?php echo $form->field($model, 'about_us_thumbnail')->widget(
    Upload::class,
    [
        'url' => ['/file/storage/upload'],
        'maxFileSize' => uploadMaxSize(),
        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
    ]);
?>

<?php echo $form->field($model, 'image_before')->widget(
    Upload::class,
    [
        'url' => ['/file/storage/upload'],
        'maxFileSize' => uploadMaxSize(),
        'acceptFileTypes' => new JsExpression('/(\.|\/)(jpe?g|png)$/i'),
    ]);
?>

<?php echo $form->field($model, 'image_after')->widget(
    Upload::class,
    [
        'url' => ['/file/storage/upload'],
        'maxFileSize' => uploadMaxSize(),
        'acceptFileTypes' => new JsExpression('/(\.|\/)(jpe?g|png)$/i'),
    ]);
?>

<?php
// Prepare display value from timestamp or string
$displayDate = '';
if (!empty($model->published_at)) {
    if (is_numeric($model->published_at)) {
        $displayDate = date('Y-m-d H:i', (int)$model->published_at);
    } else {
        $ts = strtotime($model->published_at);
        if ($ts) { $displayDate = date('Y-m-d H:i', $ts); }
    }
}
// Нативный HTML5 datetime-local для надёжного календаря с системными кнопками
$displayDateLocal = '';
if (!empty($displayDate)) {
    // преобразуем 'Y-m-d H:i' -> 'Y-m-dTH:i'
    $displayDateLocal = str_replace(' ', 'T', $displayDate);
}
echo $form->field($model, 'published_at')->input('datetime-local', [
    'class' => 'form-control',
    'value' => $displayDateLocal,
    'step' => 60,
]);

$this->registerJs(<<<JS
// преобразуем значение 'YYYY-MM-DDTHH:mm' обратно в timestamp перед отправкой формы, если модель ожидает timestamp
document.addEventListener('submit', function(e){
  var form = e.target;
  if (form && form.querySelector && form.querySelector('#article-published_at')){
    var inp = form.querySelector('#article-published_at');
    if (inp && inp.value && /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/.test(inp.value)){
      var ts = Date.parse(inp.value);
      if (!isNaN(ts)){
        form.querySelector('[name="Article[published_at]"]').value = Math.floor(ts/1000);
      }
    }
  }
}, true);
JS
);
?>

<div class="form-group">
    <?php echo Html::submitButton(
        $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
