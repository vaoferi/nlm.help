<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Testimonial */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Testimonial',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Testimonials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="testimonial-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
