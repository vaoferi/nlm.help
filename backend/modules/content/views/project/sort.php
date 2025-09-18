<?php

/**
 * Created by PhpStorm.
 * User: rex
 * Date: 09.01.19
 * Time: 13:01
 */

/* @var $this \yii\web\View */
/* @var $models array|\common\models\Project[] */
/* @var $formModel \yii\base\DynamicModel */
$this->title = Yii::t('backend', 'Sorting {modelClass}', [
    'modelClass' => 'Partners',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<?= $form->field($formModel, 'orders')->label(Yii::t('backend', 'Order'))->widget(\kartik\sortinput\SortableInput::class, [
    'items' => \yii\helpers\ArrayHelper::map($models, 'id', function(\common\models\Project $model) {
        return ['content' => $model->title];
    }),
    'hideInput' => true,
    'options' => ['class'=>'form-control', 'readonly'=>true]
]) ?>
<?= \yii\helpers\Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php \yii\widgets\ActiveForm::end(); ?>