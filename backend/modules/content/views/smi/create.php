<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Smi */

$this->title = Yii::t('backend', 'Create {modelClass}',['modelClass'=> 'публикации']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Публикации'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="smi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
