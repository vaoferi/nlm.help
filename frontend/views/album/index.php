<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $models array|\common\models\PhotoAlbum[] */
/* @var $pagination \yii\data\Pagination */
/* @var $sliderAlbums array|\common\models\PhotoAlbum[] */

$this->title = Yii::t('frontend', 'Albums');
$this->params['custom_header'] = [
    'class' => 'news-hero',
    'content' => $this->render('_header_slider', [
        'albums' => $sliderAlbums
    ])
];
?>
    <section class="albulm-page">
        <div class="container">
            <ul class="albulm-page__list">
                <?php foreach ($models as $model) : ?>
                    <li class="albulm-page__item">
                        <a href="<?= \yii\helpers\Url::to(['album/view', 'id' => $model->id]) ?>">
                            <div class="albulm-page__img">
                                <img src="<?= Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $model->getThumbnailPath()], true) ?>">
                            </div>
                            <div class="albulm-page__info">
                                <time><?= Yii::$app->formatter->asDate($model->created_at) ?></time>
                                <p><?= $model->title ?></p>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pagination]) ?>
    </section>
