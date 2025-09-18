<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */

?>
<section class="action">
    <div class="container">
        <div class="action__wrapper">
            <div class="action__blocks">
                <div class="action__block">
                    <div class="action__title">
                        <div class="action__title-text">
                            <?= Yii::t('frontend', 'Sponsor a project') ?>
                        </div>
                        <div class="action__title-icon-block">
                            <img class="action__title-icon" src="/img/heart.png" alt="img">
                        </div>
                    </div>
                    <div class="action__other-block">
                        <div class="action__numbers-block">
                            <div class="action__number-one-block">
                                <div class="action__number">
                                    <?php echo Yii::$app->keyStorage->get('home.action.block1.first', 0) ?>
                                </div>
                                <div class="action__number-text">
                                    <?= Yii::t('frontend', 'People are living in shelters now') ?>
                                </div>
                            </div>
                            <div class="action__number-one-block">
                                <div class="action__number">
                                    <?php echo Yii::$app->keyStorage->get('home.action.block1.second', 0) ?>
                                </div>
                                <div class="action__number-text">
                                    <?= Yii::t('frontend', 'Got asylum all the time') ?>
                                </div>
                            </div>

                        </div>
                        <a href="<?= \yii\helpers\Url::to(['site/donate']) ?>" class="action__btn">
                            <?= Yii::t('frontend', 'Participate') ?>

                        </a>
                    </div>
                </div>
                <div class="action__block">
                    <div class="action__title">
                        <div class="action__title-text">
                            <?= Yii::t('frontend', 'Help with clothing, food and medicine') ?>
                        </div>
                        <div class="action__title-icon-block">
                            <img class="action__title-icon" src="/img/cart.png" alt="img">
                        </div>
                    </div>
                    <div class="action__other-block">
                        <div class="action__numbers-block">
                            <div class="action__number-one-block">
                                <div class="action__number">
                                    <?php echo Yii::$app->keyStorage->get('home.action.block2.first', 0) ?>
                                </div>
                                <div class="action__number-text">
                                    <?= Yii::t('frontend', 'People are dressed thanks to us') ?>
                                </div>
                            </div>
                            <div class="action__number-one-block">
                                <div class="action__number">
                                    <?php echo Yii::$app->keyStorage->get('home.action.block2.second', 0) ?>
                                </div>
                                <div class="action__number-text">
                                    <?= Yii::t('frontend', 'Servings of food dispensed') ?>
                                </div>
                            </div>

                        </div>
                        <div class="action__numbers-center-block">
                            <div class="action__number-one-block">
                                <div class="action__number">
                                    <?php echo Yii::$app->keyStorage->get('home.action.block2.thrid', 0) ?>
                                </div>
                                <div class="action__number-text">
                                    <?= Yii::t('frontend', 'Provided medical services') ?>
                                </div>
                            </div>
                        </div>
                        <a href="<?= \yii\helpers\Url::to(['site/contact']) ?>" class="action__btn">
                            <?= Yii::t('frontend', 'donate') ?>
                        </a>
                    </div>
                </div>
                <div class="action__block">
                    <div class="action__title">
                        <div class="action__title-text">
                            <?= Yii::t('frontend', 'Become a volunteer') ?>
                        </div>
                        <div class="action__title-icon-block">
                            <img class="action__title-icon" src="/img/volunteer.png" alt="img">
                        </div>
                    </div>
                    <div class="action__other-block">
                        <div class="action__numbers-block">
                            <div class="action__number-one-block">
                                <div class="action__number">
                                    <?php echo Yii::$app->keyStorage->get('home.action.block3.first', 0) ?>
                                </div>
                                <div class="action__number-text">
                                    <?= Yii::t('frontend', 'Permanent volunteers') ?>
                                </div>
                            </div>
                            <div class="action__number-one-block">
                                <div class="action__number">
                                    <?php echo Yii::$app->keyStorage->get('home.action.block3.second', 0) ?>
                                </div>
                                <div class="action__number-text">
                                    <?= Yii::t('frontend', 'Temporary volunteers for {year}', ['year' => 2020]) ?>

                                </div>
                            </div>

                        </div>
                        <a href="<?= \yii\helpers\Url::to(['site/contact']) ?>" class="action__btn">
                            <?= Yii::t('frontend', 'Become a volunteer') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>