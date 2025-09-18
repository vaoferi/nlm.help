<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Magazine */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Magazines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="magazine-view">

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
            <?= Html::img($model->glideThumbnail(), ['class' => 'img-responsive center-block']) ?>
        </div>
        <div class="col-sm-8">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'number',
                    'alt',
                    'attachment' => [
                        'attribute' => 'attachment',
                        'value' => Html::a(Yii::t('backend', 'Open'), ['/file/storage/view', 'path' => $model->attachment_path]),
                        'format' => 'html'
                    ],
                    'created_at:datetime',
                    'updated_at:datetime'
                ],
            ]) ?>
        </div>
    </div>

</div>
