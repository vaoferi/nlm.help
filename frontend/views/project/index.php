<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $projects array|\common\models\Project[] */
/* @var $pagination \yii\data\Pagination */
/* @var $sliderProjects array|\common\models\Project[] */
/* @var $partnersFilter array */

$this->title = Yii::t('frontend', 'Projects');
//$this->params['custom_header'] = [
//    'class' => 'projects-page-hero',
//    'content' => $this->render('_header_slider', [
//        'projects' => $sliderProjects
//    ])
//];

$filterStatus = Yii::$app->getRequest()->get('status',0);

$this->registerJs(<<<JS
$('#filter-form').find('input').on('change', function(){
    $('#filter-form').submit();
})
JS
);
?>
<section class="news-page projects-page-filter">
    <?php ActiveForm::begin(['method' => 'get', 'action' => ['/project/index'], 'id' => 'filter-form']); ?>
    <div class="news-page__filter">
        <div class="news-page__filter-top-wrap">
            <div class="news-page__filter-top">
                <?php /*
                <div class="news-page__filter-item">
                    <div class="input-wrap">
                        <input name="status" id="all-projects" type="radio"
                               value="" <?= $filterStatus === '' || $filterStatus === null ? 'checked' : '' ?>>
                        <label for="all-projects"><?= Yii::t('frontend', 'All') ?></label>
                    </div>
                </div>
                */?>
                <div class="news-page__filter-item">
                    <div class="input-wrap">
                        <input name="status" id="current-projects" type="radio"
                               value="0" <?= $filterStatus == '0' ? 'checked' : '' ?>>
                        <label for="current-projects"><?= Yii::t('frontend', 'Current') ?></label>
                    </div>
                </div>
                <div class="news-page__filter-item">
                    <div class="input-wrap">
                        <input name="status" id="completed-projects" type="radio"
                               value="1" <?= $filterStatus == '1' ? 'checked' : '' ?>>
                        <label for="completed-projects"><?= Yii::t('frontend', 'Completed') ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</section>
<section class="projects-page-projects">
    <div class="container">
        <div class="projects-page-projects-wrap">
            <?php foreach ($projects as $project) : ?>
                <div class="progress__item">
                    <div class="progress__top">
                        <div class="progress__img">
                            <div class="progress__img-wrap" style="background-image: url(<?= Yii::$app->glide->createSignedUrl([
                                'glide/index',
                                'path' => $project->thumbnail_path
                            ], true) ?>);">
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
                        <a href="<?= \yii\helpers\Url::to(['site/donate']) ?>"><?= Yii::t('frontend', 'I can help') ?></a>
                        <?php /* <a href="<?= \yii\helpers\Url::to(['project/donate', 'id' => $project->id]) ?>"><?= Yii::t('frontend', 'I can help') ?></a> */ ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pagination]) ?>
</section>