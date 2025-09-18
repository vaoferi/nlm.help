<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

use yii\widgets\LinkPager;

/* @var $this \yii\web\View */
/* @var $partners array|\common\models\Partner[] */
/* @var $pagination \yii\data\Pagination */
$this->title = Yii::t('frontend', "Partners");
?>
<section class="partners-page">
    <div class="container">
        <div class="partners-page__wrap">
            <h1><?= Yii::t('frontend', 'Partners') ?>:</h1>
            <ul class="partners-page__list">
                <?php foreach ($partners as $partner): ?>
                    <li class="partners-page__item">
                        <div class="partners-page__item-top">
                            <div class="partners-page__item-img">
                                <img src="<?= Yii::$app->glide->createSignedUrl([
                                    'glide/index',
                                    'path' => $partner->thumbnail_path
                                ], true) ?>" alt="">
                            </div>
                        </div>
                        <div class="partners-page__item-body">
                            <h2><?= $partner->name ?></h2>
                            <p><?= $partner->description ?></p>
                            <div class="partners-page__item-links">
                                <a class="partners-page__icon partners-page__icon-folder" href="<?= $partner->url ?>"
                                   target="_blank" rel="nofollow"><?= Yii::t('frontend', 'Website') ?></a>
                                <?php if ($partner->articlePartners !== []): ?>
                                    <a class="partners-page__icon partners-page__icon-new"
                                       href="<?= \yii\helpers\Url::to(['article/index', 'partner' => $partner->id]) ?>"
                                       target="_blank"
                                       rel="nofollow"><?= Yii::t('frontend', 'Related news') ?>
                                        <span class="count">(<?= count($partner->articlePartners) ?>)</span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($partner->partnerProjects !== []) : ?>
                                    <a class="partners-page__icon partners-page__icon-task"
                                       href="<?= \yii\helpers\Url::to([
                                           'project/index',
                                           'partner' => $partner->id
                                       ]) ?>" target="_blank"
                                       rel="nofollow"><?= Yii::t('frontend', 'Related projects') ?>
                                        <span class="count">(<?= count($partner->partnerProjects) ?>)</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>

        <?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pagination]) ?>
    </div>
</section>

