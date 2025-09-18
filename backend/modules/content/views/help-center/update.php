<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HelpCenter */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Help Center',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Help Centers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="help-center-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
