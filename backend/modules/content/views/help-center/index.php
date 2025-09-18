<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\content\models\search\HelpCenterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Help Centers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-center-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create Help Center'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'place_name' => [
                'attribute' => 'place_name',
                'value' => function (\common\models\HelpCenter $model) {
                    return \yii\helpers\ArrayHelper::getValue($model::getPlaceNames(), $model->place_name);
                },
                'filter' => \common\models\HelpCenter::getPlaceNames(),
            ],
            'name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
