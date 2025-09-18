<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PhotoAlbum */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Photo Album',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Photo Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="photo-album-update">
    <?php echo Html::a(Yii::t('backend', 'Update Photos'), ['update-photos', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
