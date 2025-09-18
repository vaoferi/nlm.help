<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Magazine */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Magazine',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Magazines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="magazine-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
