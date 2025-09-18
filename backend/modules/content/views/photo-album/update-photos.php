<?php

/**
 * Created by PhpStorm.
 * User: rex
 * Date: 14.01.19
 * Time: 11:34
 */

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\imperavi\Widget;

/* @var $this \yii\web\View */
/* @var $model array|\common\models\PhotoAlbum|null */
/* @var $photos \common\models\Photo[] */
?>

<?php
$form = \yii\widgets\ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 4, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-safsaffaasf', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $photos[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'title',
                'description',
                'alt',
            ],
        ]); ?>

        <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($photos as $i => $photo): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <div class="pull-right">
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                        class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$photo->isNewRecord) {
                            echo Html::activeHiddenInput($photo, "[{$i}]id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <?php echo Html::a(\yii\helpers\Html::img(
                                    $photo->glide(['w' => 400]),
                                    ['class' => 'article-thumb img-responsive center-block']
                                ), $photo->glide(), ['class' => 'fancy-default']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($photo, "[{$i}]title")->widget(\common\widgets\MultiLanguageField::class, [
                                    'widgetOptions' => function (\yii\widgets\ActiveField $field) {
                                        return $field->textInput(['maxlength' => true]);
                                    }
                                ]) ?>
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($photo, "[{$i}]alt")->widget(\common\widgets\MultiLanguageField::class, [
                                    'widgetOptions' => function (\yii\widgets\ActiveField $field) {
                                        return $field->textInput(['maxlength' => true]);
                                    }
                                ]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($photo, "[{$i}]description")->widget(\common\widgets\MultiLanguageField::class, [
                                    'widgetOptions' => function (\yii\widgets\ActiveField $field) {
                                        return $field->widget(
                                            Widget::class,
                                            [
                                                'plugins' => ['fullscreen', 'fontcolor', 'video'],
                                                'options' => [
                                                    'buttonSource' => true,
                                                    'convertDivs' => false,
                                                    'removeEmptyTags' => true,
                                                    'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                                                ],
                                            ]
                                        );
                                    }
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>
<?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php \yii\widgets\ActiveForm::end(); ?>
