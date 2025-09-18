<?php
use common\models\UserSocialNetwork;
use yii\helpers\Html;
?>

<div class="about-us__info-wrap">
    <?php foreach ($users as $user): ?>
        <div id="author-<?php echo Html::encode($user->id); ?>" class="about-us__info">
            <button class="about-us__info-close" aria-label="close popup"></button>
            <div class="about-us__info-row">
                <?php if ($user->userProfile->getFullName()): ?>
                    <span><?php echo Yii::t('frontend', 'Name:') ?></span>
                    <p><?php echo Html::encode($user->userProfile->getFullName()); ?></p>
                <?php endif; ?>
            </div>
            <div class="about-us__info-row">
                <?php if ($user->userProfile->info): ?>
                    <span><?php echo Yii::t('frontend', 'About myself:') ?></span>
                    <p><?php echo Html::encode($user->userProfile->info); ?></p>
                <?php endif; ?>
            </div>
            <div class="about-us__info-row">
                <?php if (!empty($user->userSocialNetworks)): ?>
                    <span><?php echo Yii::t('frontend', 'Contacts:') ?></span>
                    <ul>
                        <?php foreach ($user->userSocialNetworks as $userSocialNetwork): ?>
                            <li>
                                <span><?php echo UserSocialNetwork::getSocialNetworkTitle($userSocialNetwork->social_network) ?></span>
                                <a title="<?php echo $userSocialNetwork->link; ?>" target="_blank" rel="nofollow" href="<?php echo $userSocialNetwork->link; ?>"><?php echo $userSocialNetwork->link; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
