<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 * @var $this \yii\web\View
 * @var $projects \common\models\Project[]
 */
?>
<?php /*
<div class="projects-page-hero__wrap">
    <div class="projects-page-hero__slider">
        <?php foreach ($projects as $project) : ?>
            <div class="projects-page-hero__slider-item">
                <div class="projects-page-hero__slider-img"
                     style="background-image: linear-gradient(to bottom, rgba(215, 215, 215, 0.5) 0%, #ffffff 100%), url(<?= Yii::$app->glide->createSignedUrl([
                         'glide/index',
                         'path' => $project->thumbnail_path
                     ], true) ?>);"></div>
                <div class="projects-page-hero__slider-content">
                    <h2><?= $project->title ?></h2>
                    <p class="projects-page-hero__slider-content__progress"><?= Yii::t('frontend', 'Progress: {collected} / {required}', [
                            'collected' => Yii::$app->formatter->asCurrency($project->collected_amount),
                            'required' => Yii::$app->formatter->asCurrency($project->required_amount)
                        ]) ?></p>
                    <p class="projects-page-hero__slider-content__info"><?= $project->short_description ?></p>
                    <div class="projects-page-hero__slider-content__links">
                        <a class="projects-page-hero__slider-content__details" href="<?= \yii\helpers\Url::to(['project/view', 'slug' => $project->slug]) ?>"><?= Yii::t('frontend', 'details') ?></a>
                        <a class="projects-page-hero__slider-content__help" href="<?= \yii\helpers\Url::to(['project/donate', 'id' => $project->id]) ?>" ><?= Yii::t('frontend', 'I can help') ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
 </div>
*/ ?>
