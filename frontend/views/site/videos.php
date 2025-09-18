<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $models array|\common\models\Video[] */
/* @var $pagination \yii\data\Pagination */
$this->title = Yii::t('frontend', 'Videos');
?>
<section class="videos-page">
    <div class="container">
        <div class="videos-page__wrap videos-page__wrap--grid">
            <h1><?= Yii::t('frontend', 'Videos') ?>:</h1>
            <div class="videos-page__list-wrap">
                <ul class="videos-page__list">
                    <?php foreach ($models as $model) : ?>
                        <li class="videos-page__item">
                            <div class="videos-page__item-top">
                                <div class="videos-page__item-video">
                                    <?= $model->embed_code ?>
                                </div>
                            </div>
                            <div class="videos-page__item-bottom">
                                <h2><?= $model->title ?></h2>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pagination]) ?>
</section>
