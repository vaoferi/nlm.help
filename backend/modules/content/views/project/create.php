<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Project',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
