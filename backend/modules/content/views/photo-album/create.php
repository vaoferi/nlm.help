<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PhotoAlbum */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Photo Album',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Photo Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-album-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
