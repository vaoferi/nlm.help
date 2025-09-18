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

$this->title = Yii::t('frontend', 'Articles');
$this->params['custom_header'] = [
    'class' => 'news-hero',
    'content' => $this->render('_header_slider', [
        'articles' => $sliderArticles
    ])
];
$filterPartner = Yii::$app->getRequest()->get('partner');
$filterTime = Yii::$app->getRequest()->get('time');

$this->registerJs(<<<JS
$('#filter-form').find('select').on('change', function(){
    $('#filter-form').submit();
})
JS
);
$action = ['article/index'];
if ($about_us) {
    $action = array_merge($action, ['about_us' => 1]);
}
?>

<section class="news-page">
    <div class="news-page__filter-news">
        <div class="news-page__filter-news-form-wrap" <?= ($partner || $project || $help_center ? "style=\"display: block\"" : '') ?>>
            <?php ActiveForm::begin(['id' => 'filter-form', 'action' => $action, 'method' => 'get']); ?>
            <div class="news-page__filter-news-form">
                <div class="input-wrap">
                    <?= Html::dropDownList('partner', $partner, $partnersFilters, ['prompt' => Yii::t('frontend', 'All partners')]) ?>
                </div>
                <div class="input-wrap">
                    <?= Html::dropDownList('project', $project, $projectsFilters, ['prompt' => Yii::t('frontend', 'All projects')]) ?>
                </div>
                <div class="input-wrap">
                    <?= Html::dropDownList('help_center', $help_center, $helpCentersFilters, ['prompt' => Yii::t('frontend', 'All help centers')]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="news-page__filter-bottom">
            <div class="news-page__filter-bottom-decor"></div>
            <button class="news-page__filter-btn--js" type="button"><?= Yii::t('frontend', 'Filters') ?></button>
        </div>
    </div>

    <div class="news-page__wrap">
        <div class="articles__col articles__col--left news-page__wrap--grid">
            <?php foreach ($articles as $article) : ?>

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
    </div>
    <?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pagination]) ?>
</section>
