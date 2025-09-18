<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\payments\models\search\OrderProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Order Service');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-project-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create payment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'full_name',
            'email:email',
            'status:boolean',
            'updated_at:datetime' => [
                'attribute' => 'updated_at',
                'filter' => false,
                'format' => 'datetime'
            ],
            'payment_system' => [
                'attribute' => 'payment_system',
                'value' => function (\common\models\OrderService $model) {
                    return \yii\helpers\ArrayHelper::getValue(\common\models\OrderAbstract::paymentSystems(), $model->payment_system);
                },
                'filter' => \common\models\OrderAbstract::paymentSystems()
            ],
            'transaction_id',
            'amount:currency',
            'amount_received:currency',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
