<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $albums array|\common\models\PhotoAlbum[] */
?>
<div class="albulm-hero__wrap">
    <div class="albulm-hero__slider albulm-hero__slider--js">
        <?php foreach ($albums as $album) : ?>
            <div class="albulm-hero__slider-item">
                <div class="albulm-hero__slider-img"
                     style="background-image: linear-gradient(to bottom, rgba(215, 215, 215, 0.5) 0%, #ffffff 100%), url(<?= Yii::$app->glide->createSignedUrl([
                         'glide/index',
                         'path' => $album->getThumbnailPath()
                     ], true) ?>);"></div>
                <div class="albulm-hero__slider-content">
                    <time><?= Yii::$app->formatter->asDate($album->created_at) ?></time>
                    <h2><?= $album->title ?></h2>
                    <p></p>
                    <a href="<?= \yii\helpers\Url::to(['album/view', 'id' => $album->id]) ?>"><?= Yii::t('frontend', 'view') ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>