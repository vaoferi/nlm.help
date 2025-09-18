<?php

use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Videos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create Video'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'created_at',
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
            ],            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
