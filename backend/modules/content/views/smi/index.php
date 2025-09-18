<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\SmiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Публикации');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="smi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}',['modelClass'=> 'публикации']), ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'cat_smi_id',
                'options' => ['style' => 'width: 15%'],
                'value' => function ($model) {
                    return $model->catSmi ? $model->catSmi->title : null;
                },
                'filter' => ArrayHelper::map(\common\models\CatalogSmi::find()->all(), 'id', 'title'),
            ],
            'url:url',
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
