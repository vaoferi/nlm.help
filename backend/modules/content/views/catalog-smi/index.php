<?php

use yii\helpers\Html;
use yii\grid\GridView;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\CatalogSmiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Каталог СМИ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-smi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}',['modelClass'=> 'СМИ']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'options' => ['style' => 'width: 5%'],
            ],
//            'id',
            [
                'attribute' => 'title',
                'value' => function ($model) {
                    return Html::a($model->title, ['update', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
//            'image_path',
//            'image_base_url:url',
            [
                'attribute' => 'created_at',
                'options' => ['style' => 'width: 10%'],
                'format' => 'datetime',
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'phpDatetimeFormat' => 'dd.MM.yyyy',
                    'momentDatetimeFormat' => 'DD.MM.YYYY',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")'),
                    ],
                ]),
            ],
            [
                'attribute' => 'updated_at',
                'options' => ['style' => 'width: 10%'],
                'format' => 'datetime',
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'phpDatetimeFormat' => 'dd.MM.yyyy',
                    'momentDatetimeFormat' => 'DD.MM.YYYY',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")'),
                    ],
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 5%'],
            ],
        ],
    ]); ?>


</div>
