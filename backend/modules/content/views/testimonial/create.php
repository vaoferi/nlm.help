<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Testimonial */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Testimonial',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Testimonials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonial-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
