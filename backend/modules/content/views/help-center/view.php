<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\HelpCenter */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Help Centers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-center-view">

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
            <img style="width: 100%;" src="<?= Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $model->thumbnail_path], true) ?>" alt="">
        </div>
        <div class="col-sm-8">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'place_name',
                    'name',
                    'description:html',
                    'contacts:raw',
                    [
                            'label' => Yii::t('backend', 'Service Names'),
                        'value' => function(\common\models\HelpCenter $model) {
                            return implode(', ', \yii\helpers\ArrayHelper::getColumn($model->helpCenterServices, 'service_name'));
                        }
                    ],

                ],
            ]) ?>
        </div>
    </div>

</div>
