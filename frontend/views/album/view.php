<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $model array|\common\models\PhotoAlbum|null */
$this->title = $model->title;
$this->params['custom_header'] = [
    'class' => 'news-hero',
    'content' => $this->render('_header_photo', [
        'model' => $model
    ])
];
?>
<section class="photos-page">
    <div class="container">
        <ul class="photos-page__list">
            <?php foreach ($model->photos as $photo) :
                $photoUrl = Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => $photo->photo_path
                ], true)
                ?>
                <li class="photos-page__item">
                    <a data-fancybox="gallery-photos" style="background-image: url(<?= $photoUrl ?>);" href="<?= $photoUrl ?>" data-caption="<div class='photos-page__desc'><h1><?= $photo->title ?></h1><p><?= $photo->description ?></p></div>">
                        <img src="<?= $photoUrl ?>" alt="<?= $photo->alt ?>">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>