<?php

use common\grid\EnumColumn;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\PhotoAlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Photo Albums');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-album-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create Photo Album'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'enum' => \common\models\PhotoAlbum::statuses(),
                'filter' => \common\models\PhotoAlbum::statuses(),
            ],
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
