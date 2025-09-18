<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $model array|\common\models\Project|null */
/* @var $articles \common\models\Article[] */
/* @var $partners \common\models\Partner[] */
/* @var $lastPayments \common\models\OrderProject[] */
$this->title = $model->title;
$thumb = Yii::$app->glide->createSignedUrl([
    'glide/index',
    'path' => $model->thumbnail_path
], true);
$this->registerMetaTag([
    'property' => 'og:image:secure_url',
    'content' => $thumb,
]);
$this->registerMetaTag([
    'property' => 'og:image',
    'content' => $thumb
]);
$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $model->title,
]);
$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $model->short_description,
]);
$this->registerMetaTag([
    'property' => 'og:type',
    'content' => 'article',
]);
?>

<section class="projects-one">
    <div class="projects-one-wrap">

        <div class="projects-one-right">
            <div class="projects-one-info">
                <div class="projects-one-info__left">
                    <div class="projects-one-info__img"
                         style="background-image: url(<?= Yii::$app->glide->createSignedUrl([
                             'glide/index',
                             'path' => $model->thumbnail_path
                         ], true) ?>);">
                    </div>

                    <aside class="projects-one-left">
                        <?php if(!empty($model->projectAttachments)): ?>
                            <div class="projects-one-other__report-wrap">
                                <div class="projects-one-other__report">
                                    <img src="/img/general/document-filled.png">
                                    <button class="projects-one-other__btn projects-one-other__btn--js"><?= Yii::t('frontend', 'See all documents') ?></button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="projects-one-care">
                            <?php if ($lastPayments) : ?>
                                <h3><?= Yii::t('frontend', 'They really care:') ?></h3>
                                <ul class="projects-one-care__list">
                                    <?php foreach ($lastPayments as $payment) : ?>
                                        <li class="projects-one-care__item">
                                            <h4 class="projects-one-care__item-name"><?= $payment->full_name?></h4>
                                            <p class="projects-one-care__item-donate"><?= Yii::$app->formatter->asCurrency($payment->amount_received) ?></p>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </aside>
                </div>
                <div class="projects-one-info__right">
                    <div class="projects-one-info__progress">
                        <div class="progress__progressbar"
                             style="background-size: <?= $model->getCollectedPercent() ?>% 100%;">
                            <div class="progress__progressbar-info"
                                 style="right: <?= 100 - $model->getCollectedPercent() ?>%;">
                                <span class="deadline-info"><?= Yii::t('frontend', 'Deadline: {date}', [
                                        'date' => Yii::$app->formatter->asDate($model->due_date)
                                    ]) ?></span>
                                <span class="progress-info"><?= Yii::t('frontend', 'Progress: {collected} / {required}', [
                                        'collected' => Yii::$app->formatter->asCurrency($model->collected_amount),
                                        'required' => Yii::$app->formatter->asCurrency($model->required_amount)
                                    ]) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="projects-one-info__text">
                        <h1><?= $model->title ?></h1>
                        <p><?= $model->description ?></p>
                    </div>
                </div>
                <div class="projects-one-info__links">
                    <a class="projects-one-info__links-help" href="<?= \yii\helpers\Url::to(['site/donate']) ?>"
                       title="<?= Yii::t('frontend', 'I can help') ?>"><?= Yii::t('frontend', 'I can help') ?></a>
                </div>
            </div>
            <div class="projects-one-other">
                <div class="projects-one-other__article-wrap projects-one-other--news">
                    <?php foreach ($articles as $article) : ?>
                        <div class="projects-one-other__article"
                             style="background-image: linear-gradient(#e0e0e08c, rgba(224, 224, 224, .55)),, url(<?= Yii::$app->glide->createSignedUrl([
                                 'glide/index',
                                 'path' => $article->thumbnail_path
                             ]) ?>);">
                            <a href="<?= \yii\helpers\Url::to(['article/view', 'slug' => $article->slug]) ?>"
                               title="Read">
                                <time><?= Yii::$app->formatter->asDate($article->published_at) ?>
                                    <img src="/img/general/article-icon-megaphone.png">
                                </time>
                                <h4><?= $article->title ?></h4>
                                <p><?= $article->short_description ?></p>
                                <button><?= Yii::t('frontend', 'Read') ?></button>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($partners) : ?>
                    <div class="projects-one-other__partners projects-one-other--partners">
                        <h3><?= Yii::t('frontend', 'Partners') ?>:</h3>
                        <?php foreach ($partners as $partner) : ?>
                            <a href="<?= $partner->url ?>" title="<?= $partner->name ?>" target="_blank">
                                <div class="projects-one-other__partners-img">
                                    <img src="<?= Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $partner->thumbnail_path], true) ?>">
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="popup-document__overlay">
    <div class="popup-document">
        <button type="button" class="popup-document__close"></button>
        <div class="popup-document__slider">
        <?php foreach ($model->projectAttachments as $attachment) :
            $mimeType = Yii::$app->fileStorage->getFilesystem()->getMimetype($attachment->path);
            ?>
            <div class="popup-document__item">
                <?php if ($mimeType == 'application/pdf') : ?>
                    <iframe width="100%" height="100%" src="<?= \yii\helpers\Url::to(['project/attachment-download', 'id' => $attachment->id]) ?>" frameborder="0"></iframe>
                <?php else: ?>
                    <div class="popup-document__img">
                        <img src="<?= \yii\helpers\Url::to(['project/attachment-download', 'id' => $attachment->id]) ?>"
                             alt="">
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>