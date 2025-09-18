<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 * @var $model \common\models\PhotoAlbum
 */?>

<div class="albulm-hero__wrap">
    <div class="albulm-hero__slider">
        <div class="albulm-hero__slider-item">
            <div class="albulm-hero__slider-img" style="background-image: linear-gradient(to bottom, rgba(215, 215, 215, 0.5) 0%, #ffffff 100%), url(<?= Yii::$app->glide->createSignedUrl([
                'glide/index',
                'path' => $model->getThumbnailPath()
            ], true) ?>);"></div>
            <div class="albulm-hero__slider-content">
                <time><?= Yii::$app->formatter->asDate($model->created_at) ?></time>
                <h2><?= $model->title ?></h2>
                <p></p>
            </div>
        </div>
    </div>
</div>
