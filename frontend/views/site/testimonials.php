<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $models array|\common\models\Article[]|\common\models\HelpCenter[]|\common\models\Partner[]|\common\models\Testimonial[]|\yii\db\ActiveRecord[] */
/* @var $pagination \yii\data\Pagination */
?>
<section class="testimonials-page">
    <div class="container">
        <div class="testimonials-page__wrap">
            <h1><?= Yii::t('frontend', 'Testimonials:') ?></h1>
            <div class="testimonials-page__list-wrap">
                <ul class="testimonials-page__list">
                    <?php foreach ($models as $model) : ?>
                        <li class="testimonials-page__item">
                            <div class="testimonials-page__item-top">
                                <div class="testimonials__img">
                                    <img src="<?= Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $model->thumbnail_path], true) ?>" width="540" height="460" alt="CaroLena Headey">
                                </div>
                            </div>
                            <div class="testimonials-page__item-bottom">
                                <h3><?= $model->title ?></h3>
                                <p><?= $model->text ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pagination]) ?>
</section>
