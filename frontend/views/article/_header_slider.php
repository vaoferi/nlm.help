<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 * @var $this \yii\web\View
 * @var $articles \common\models\Article[]
 */
?>
<div class="news-hero__wrap">
    <div class="news-hero__slider">
        <?php foreach ($articles as $article) : ?>
            <div class="news-hero__slider-item">
                <div class="news-hero__slider-img" style="background-image: linear-gradient(to bottom, rgba(215, 215, 215, 0.5) 0%, #ffffff 100%), url(<?= Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => $article->thumbnail_path
                ], true) ?>);"></div>
                <div class="news-hero__slider-content">
                    <time><?= Yii::$app->formatter->asDate($article->published_at) ?></time>
                    <h2><?= $article->title ?></h2>
                    <p><?= $article->short_description ?></p>
                    <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $article->slug]) ?>" title="details"><?= Yii::t('frontend', 'Details') ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
