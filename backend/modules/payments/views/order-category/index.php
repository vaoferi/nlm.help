<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\payments\models\search\OrderProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Order Category');
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

//            'id',
//            'comment:ntext',
            'full_name',
            'email:email',
            'project.title' => [
                'attribute' => 'category_id',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\ArticleCategory::find()->all(), 'id', 'title'),
                'value' => function (\common\models\OrderCategory $model) {
                    return $model->category->title;
                }
            ],
            // 'payment_system',
            'status:boolean',
            // 'project_id',
            'updated_at:datetime' => [
                'attribute' => 'updated_at',
                'filter' => false,
                'format' => 'datetime'
            ],
            'payment_system' => [
                'attribute' => 'payment_system',
                'value' => function (\common\models\OrderCategory $model) {
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
