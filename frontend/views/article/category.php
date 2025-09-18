<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 15.03.19
 * Time: 15:31
 * @var $category \common\models\ArticleCategory
 * @var $articles \common\models\Article[]
 * @var $this \yii\web\View
 * @var $pagination \yii\data\Pagination
 */
$signedUrl = Yii::$app->glide->createSignedUrl([
    'glide/index',
    'path' => $category->thumbnail_path
], true);
$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $category->title,
]);
$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $category->description,
]);
$this->registerMetaTag([
    'property' => 'og:type',
    'content' => 'article',
]);
$this->params['custom_header'] = [
    'class' => 'news-one-hero',
    'content' => "<div class=\"news-one-hero__wrap\" style=\"background-image: linear-gradient(rgba(223, 224, 224, .1), rgba(255, 255, 255, 1)), url(" . $signedUrl . "); filter: blur(3px);\"></div>",
    'og-meta' => $category->thumbnail_path
];
?>
<article class="news-one-info about-page-info category-article">
<!--    <h5 class="category__title">more than 2000 all over the country</h5>-->
    <h1><?= $category->title ?></h1>
    <p><?= $category->description ?></p>
    <div class="projects-one-info__links">
        <a class="projects-one-info__links-help category__btn" href="<?= \yii\helpers\Url::to(['site/donate']) ?>" ><?= Yii::t('frontend', 'I can help') ?></a>
    </div>
</article>

<section class="category-news">
    <div class="articles__wrap">
        <div class="articles__col articles__col--left category__wrap">
            <?php foreach ($articles as $post) : ?>
                <div class="articles__item">
                    <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $post->slug]) ?>">
                        <time>
                            <span><?= Yii::$app->formatter->asDate($post->published_at) ?></span>
                        </time>
                        <h3><?= $post->title ?></h3>
                        <p><?= $post->short_description ?></p>
                    </a>
                    <?php if (!empty($post->thumbnail_path)) : ?>
                        <div class="articles__item-img">
                            <img src="<?= Yii::$app->glide->createSignedUrl([
                                'glide/index',
                                'path' => $post->thumbnail_path
                            ], true) ?>">
                            <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $post->slug]) ?>" class="articles__item-link"><?= Yii::t('frontend', 'Read') ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pagination]) ?>
</section>