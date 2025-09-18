<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PhotoAlbum */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Photo Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-album-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Update Photos'), ['update-photos', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'status' => [
                'attribute' => 'status',
                'value' => \yii\helpers\ArrayHelper::getValue($model::statuses(), $model->status, $model->status)
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'createdBy.publicIdentity',
            'updatedBy.publicIdentity',
            'slug',
        ],
    ]) ?>

    <?php if ($model->photos) {
    foreach ($model->photos as $photo) : ?>
        <a rel="fancy-group" title="<?= $photo->title ?>" href="<?= $photo->glide() ?>">
            <img alt="<?= $photo->alt ?>" src="<?= $photo->glide(['w' => 100]) ?>">
        </a>
    <?php endforeach; } ?>
</div>
