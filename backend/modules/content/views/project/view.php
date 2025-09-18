<?php

use common\grid\EnumColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-3">
            <?php if ($model->thumbnail_path): ?>
                <?php echo \yii\helpers\Html::img(
                    Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => $model->thumbnail_path,
                    ], true),
                    ['class' => 'img-rounded img-responsive center-block']
                ) ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-9">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'short_description',
                    [
                        'attribute' => 'status',
                        'value' => ArrayHelper::getValue($model::statuses(), $model->status, $model->status)
                    ],
                    'required_amount',
                    'collected_amount',
                    'due_date:date',
                    'created_at:datetime',
                    'updated_at:datetime',
                    'published_at:datetime',
                    'is_finished:boolean',
                ],
            ]) ?>
        </div>
    </div>
   <div class="row">
       <div class="col-xs-12">
           <?php if ($model->attachments) {
               foreach ($model->projectAttachments as $photo) : ?>
                   <a rel="fancy-group" href="<?= $photo->glide() ?>">
                       <img src="<?= $photo->glide(['w' => 100]) ?>">
                   </a>
               <?php endforeach; } ?>
       </div>
   </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $model->description ?>
        </div>
    </div>

</div>
