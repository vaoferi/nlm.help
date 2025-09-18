<?php

use common\grid\EnumColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\PartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Partners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create Partner'), ['create'], ['class' => 'btn btn-success']) ?>

        <?php echo Html::a(Yii::t('backend', 'Sort Partners'), ['sort'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'url:url',
            [
                'class' => EnumColumn::class,
                'attribute' => 'status',
                'enum' => \common\models\Partner::statuses(),
                'filter' => \common\models\Partner::statuses(),
            ],
            // 'priority',
            // 'due_date',
            'show_status:boolean',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
