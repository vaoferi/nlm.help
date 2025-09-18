<?php
/* @var $this yii\web\View */

use common\models\UserSocialNetwork;
use yii\helpers\Html;

/* @var $model common\models\Article */
/* @var $project common\models\Project */
/* @var $threeNews common\models\Article[] */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$thumb = Yii::$app->glide->createSignedUrl([
    'glide/index',
    'path' => $model->thumbnail_path
], true);

$this->registerMetaTag([
    'property' => 'og:url',
    'content' => Yii::$app->urlManager->createUrl(['view', 'slug' => $model->slug]),
]);
//$this->registerMetaTag([
//    'property' => 'og:type',
//    'content' => 'article',
//]);
$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $model->title,
]);
$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $model->short_description,
]);
//$this->registerMetaTag([
//    'property' => 'fb:app_id',
//    'content' => //TODO,
//]);
$this->params['custom_header'] = [
    'class' => 'news-one-hero',
    'og-meta' =>  $model->thumbnail_path,
    'content' => "<div class=\"news-one-hero__wrap\" style=\"background-image: linear-gradient(rgba(223, 224, 224, .1), rgba(255, 255, 255, 1)), url({$thumb}); filter: blur(3px);\"></div>"
];
?>
<article class="news-one-info">
    <time><?= Yii::$app->formatter->asDate($model->published_at) ?></time>
    <h1><?= $model->title ?></h1>
    <p><?= $model->body ?></p>

    <?php if (($model->image_before !== null) && ($model->image_after !== null)): ?>
        <?php echo \common\widgets\ComparisonSlider::widget([
            'beforeImage' => Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $model->image_before_path], true),
            'afterImage' => Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $model->image_after_path], true),
            'beforeAlt' => 'Before Image',
            'afterAlt' => 'After Image',
        ]) ?>
    <?php endif; ?>
    <?php if ($model->author->userProfile->getFullName()): ?>
            <address class="news__author">
                <a href="#" class="news__author-link news__author-link--js" title="<?php echo Yii::t('frontend', 'Author: ') . Html::encode($model->author->userProfile->getFullName()) ?>">
                    <?php echo Yii::t('frontend', 'Author: ') ?><span data-id="author-<?php echo Html::encode($model->author->id) ?>"><?php echo Html::encode($model->author->userProfile->getFullName()) ?></span>
                </a>
            </address>
    <?php endif; ?>
    <?= \common\widgets\DbText::widget(['key' => 'share_article']) ?>
</article>
<?php if ($model->articleAttachments) : ?>
    <section class="news-one-slider-wrap">
        <div class="news-one-slider news-one-slider--js">
            <?php foreach ($model->articleAttachments as $attachment) : ?>
                <div class="news-one-slider-item">
                    <a data-fancybox="gallery" href="<?= Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => $attachment->path
                    ], true) ?>"><img src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => $attachment->path,
                            'w' => 676,
                            'h' =>450
                        ], true) ?>"></a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php if ($project): ?>
    <section class="news-one-progress">
        <div class="container">
            <div class="progress__item">
                <div class="progress__top">
                    <div class="progress__img">
                        <div class="progress__img-wrap" style="background-image: url(<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => $project->thumbnail_path
                        ], true) ?>)">
                        </div>
                    </div>
                    <div class="progress__progressbar" style="background-size: <?= $project->getCollectedPercent() ?>% 100%;">
                        <div class="progress__progressbar-info" style="right: <?= 100 - $project->getCollectedPercent() ?>%;">
                            <span class="deadline-info"><?= Yii::t('frontend', 'Deadline: {date}', [
                                    'date' => Yii::$app->formatter->asDate($project->due_date)
                                ]) ?></span>
                            <span class="progress-info"><?= Yii::t('frontend', 'Progress: {collected} / {required}', [
                                    'collected' => Yii::$app->formatter->asCurrency($project->collected_amount),
                                    'required' => Yii::$app->formatter->asCurrency($project->required_amount)
                                ]) ?></span>
                        </div>
                    </div>
                </div>
                <div class="progress__bottom">
                    <h3><?= $project->title ?></h3>
                    <p><?= $project->short_description ?></p>
                </div>
                <div class="progress__links">
                    <a href="<?= \yii\helpers\Url::to(['project/view', 'slug' => $project->slug]) ?>" title="details"><?= Yii::t('frontend', 'details') ?></a>
                    <a href="<?= \yii\helpers\Url::to(['project/donate', 'id' => $project->id]) ?>" title="I can help"><?= Yii::t('frontend', 'I can help') ?></a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<section class="news-one-news">
    <div class="articles__col articles__col--left">
        <?php foreach ($threeNews as $article) : ?>
            <div class="articles__item">
                <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $article->slug]) ?>">
                    <time>
                        <span><?= Yii::$app->formatter->asDate($article->published_at) ?></span>
                    </time>
                    <h3><?= $article->title ?></h3>
                    <p><?= $article->short_description ?></p>
                </a>
                <?php if (!empty($article->thumbnail_path)) : ?>
                    <div class="articles__item-img">
                        <img src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => $article->thumbnail_path
                        ], true) ?>">
                        <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $article->slug]) ?>" class="articles__item-link"><?= Yii::t('frontend', 'Read') ?></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php if ($model->partners) : ?>
    <section class="news-one-supported">
        <h3><?= Yii::t('frontend', 'Supported by') ?></h3>
        <?php foreach ($model->partners as $partner): ?>
            <div class="news-one-supported-item">
                <a href="<?= $partner->url ?>" target="_blank">
                    <img src="<?= Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => $partner->thumbnail_path
                    ], true) ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
