<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Partner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-view">

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
        <div class="col-sm-4">
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
        <div class="col-sm-8">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'url:url',
                    [
                        'attribute' => 'status',
                        'value' => ArrayHelper::getValue($model::statuses(), $model->status, $model->status)
                    ],
                    'due_date:date',
                    'show_status:boolean',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $model->description ?>
        </div>
    </div>
</div>
