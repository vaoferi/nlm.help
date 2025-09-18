<?php

use common\grid\EnumColumn;
use common\models\SliderSertificat;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\SliderSertificatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Sliders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Slider',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'order',
//            'button_text',
            [
                'class' => EnumColumn::class,
                'attribute' => 'status',
                'options' => ['style' => 'width: 10%'],
                'enum' => SliderSertificat::statuses(),
                'filter' => SliderSertificat::statuses(),
            ],
//            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
