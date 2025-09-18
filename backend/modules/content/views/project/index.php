<?php

use common\grid\EnumColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php echo Html::a(Yii::t('backend', 'Sort Projects'), ['sort'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'slug',
            'title',
            [
                'class' => EnumColumn::class,
                'attribute' => 'status',
                'enum' => \common\models\Project::statuses(),
                'filter' => \common\models\Project::statuses(),
            ],
            'is_finished:boolean',
            // 'required_amount',
            // 'collected_amount',
            // 'due_date',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'created_at',
            // 'updated_at',
            // 'published_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
