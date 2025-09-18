<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $model \common\models\OrderProject */
$this->title = Yii::t('backend', 'Accept cash');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Order Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', ['model'=> $model]) ?>
