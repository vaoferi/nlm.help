<?php
use yii\helpers\Url;
?>
<section class="projects">
    <div class="container">
        <div class="projects__wrapper">
            <div class="projects__blocks">
                <?php foreach ($projects as $project) : ?>
                <?php $progress = round($project->getCollectedPercent(), 0);
                    ?>
                <div class="projects__block">
                    <div class="projects__image">
                        <img class="projects__img" src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => $project->thumbnail_path,
                            'w' => 755,
                            'h' => 435,
                        ], true) ?>" alt="img">
                    </div>
                    <div class="projects__other-block">
                        <div class="projects__title">
                            <?= $project->title ?>
                        </div>
                        <div class="projects__line-progress">
                            <div class="projects__have" style="width: <?= $progress ?>%;"></div>
                            <div class="projects__point" style="left: <?= $progress ?>%;"></div>
                            <div class="projects__dhave" style="width: <?= 100-$progress ?>%;"></div>
                        </div>
                        <div class="projects__numbers">
                            <div class="projects__have-block">
                                <div class="projects__have-amount">
                                    <?= Yii::$app->formatter->asCurrency($project->collected_amount) ?>
                                </div>
                                <div class="projects__have-text">
                                    <?= Yii::t('frontend', 'Collected') ?>
                                </div>
                            </div>
                            <div class="projects__have-block">
                                <div class="projects__have-amount">
                                    <?= Yii::$app->formatter->asCurrency($project->required_amount)?>
                                </div>
                                <div class="projects__have-text">
                                    <?= Yii::t('frontend', 'Target') ?>
                                </div>
                            </div>
                        </div>
                        <div class="projects__text">
                            <?= $project->short_description ?>
                        </div>
                        <div class="projects__btns">
                            <a class="projects__details" href="<?= Url::to(['project/view', 'slug' => $project->slug]) ?>">
                                <?= Yii::t('frontend', 'details') ?>
                            </a>
                            <a class="projects__help" href="<?= Url::to(['site/donate']) ?><?php //echo Url::to(['project/donate', 'id' => $project->id]) ?>">
                                <?= Yii::t('frontend', 'I can help') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <a class="projects__button" href="<?= Url::to(['project/index']) ?>"> 
                <?= Yii::t('frontend', 'All projects') ?>
            </a>
        </div>
    </div>
</section>
