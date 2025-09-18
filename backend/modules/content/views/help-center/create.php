<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HelpCenter */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Help Center',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Help Centers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-center-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
