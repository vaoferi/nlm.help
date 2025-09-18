<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Magazine */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Magazine',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Magazines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="magazine-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
