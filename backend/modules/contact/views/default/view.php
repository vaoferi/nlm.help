<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ContactForm */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Contact Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-form-view">
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'full_name',
            'phone',
            'email:email',
            'body:ntext',
            'helpCenter.name',
            'is_new:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
