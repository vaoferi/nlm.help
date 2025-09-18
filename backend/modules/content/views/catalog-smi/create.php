<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CatalogSmi */

$this->title = Yii::t('backend', 'Create {modelClass}',['modelClass'=> 'СМИ']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Catalog world press'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-smi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
