<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrderCategory */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Order Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-project-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?php if (in_array($model->payment_system, ['cash', 'bank']) && $model->status == $model::STATUS_NEW) : ?>
            <?php echo Html::a(Yii::t('backend', 'Accept'), ['cash', 'id' => $model->id], [
                'class' => 'btn btn-warning',
            ]) ?>
        <?php endif; ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'amount:currency',
            'comment:ntext',
            'full_name',
            'email:email',
            'payment_system',
            'status:boolean',
            [
                'label' => Yii::t('backend', 'Category'),
                'value' => Html::a($model->category->title, ['/content/category/update', 'id' => $model->category_id]),
                'format' => 'raw'
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'transaction_id',
            'amount_received:currency',
        ],
    ]) ?>

</div>
