<?php
/* @var $this yii\web\View */
/* @var $articles \common\models\Article[] */
/* @var $sliderArticles \common\models\Article[] */
/* @var $partnersFilters array */
/* @var $projectsFilters array */
/* @var $helpCentersFilters array */
/* @var $about_us int */
/* @var $partner int */
/* @var $project int */
/* @var $help_center int */

/* @var $pagination \yii\data\Pagination */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
//use omgdef\multilingual\MultilingualBehavior;
use common\helpers\MultilingualHelper;

//$this->title = Yii::t('frontend', 'Articles');

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'property' => 'og:url',
    'content' => Yii::$app->urlManager->createUrl(['view', 'slug' => $model->slug]),
]);
$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $model->title,
]);
$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $model->short_description,
]);

$thumb = Yii::$app->glide->createSignedUrl([
    'glide/index',
    'path' => $model->thumbnail_path
], true);
$this->params['custom_header'] = [
    'class' => 'news-one-hero',
    'og-meta' =>  $model->thumbnail_path,
    'content' => "<div class=\"news-one-hero__wrap\" style=\"background-image: linear-gradient(rgba(223, 224, 224, .1), rgba(255, 255, 255, 1)), url({$thumb}); filter: blur(3px);\"></div>"
];
?>
<article class="news-one-info">
    <h1><?= Yii::t('common', 'This Page without translate');?></h1>
    <p><?= Yii::t('common', 'Look this Article other language');?></p>
</article>
<section class="news-one-news">
    <div class="articles__col articles__col--left">
<?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
            <?php if ($code !== \Yii::$app->language) : ?>
                <?php $article = $model->getArticlelang($code); ?>
                <?php $title = '$model->'.MultilingualHelper::getFieldName('title' ,$code); ?>
            <div class="articles__item">
                <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $model->slug, 'language' => $code]) ?>">
                    <time>
                        <span><?= Yii::$app->formatter->asDate($model->published_at) ?></span>
                    </time>
                    <h3><?= $article['title']; ?></h3>
                    <p><?= $article['short_description']; ?></p>
                </a>
                <?php if (!empty($model->thumbnail_path)) : ?>
                    <div class="articles__item-img">
                        <img src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => $model->thumbnail_path
                        ], true) ?>">
                        <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $model->slug]) ?>" class="articles__item-link"><?= Yii::t('frontend', 'Read') ?></a>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>
