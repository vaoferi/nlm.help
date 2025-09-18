<?php
use yii\helpers\Html;
?>

<div class="news-one-slider about-page-slider--js">
    <?php foreach ($users as $user): ?>
        <?php $photoSrc = Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $user->photo_path], true);
        if ($photoSrc): ?>
            <div class="news-one-slider-item" data-id="author-<?php echo Html::encode($user->id); ?>">
                <img src="<?php /** @var common\models\User $user */ echo $photoSrc ?>" alt="<?php echo Html::encode($user->userProfile->getFullName() ?: 'Team Member'); ?>">
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
