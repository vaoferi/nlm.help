<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrderService */

$this->title = Yii::t('backend', 'Create payment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Order Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-project-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
