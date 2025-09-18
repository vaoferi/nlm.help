<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Slider',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
