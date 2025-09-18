<?php
/* @var $this yii\web\View */
/* @var $currentLanguage  */

use common\models\UserSocialNetwork;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;



/* @var $user common\models\User */
/* @var $project common\models\Project */
/* @var $threeNews common\models\Article[] */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$thumb = Yii::$app->glide->createSignedUrl([
    'glide/index',
    'path' => $user->photo_path
], true);
$this->params['custom_header'] = [
    'class' => 'news-one-hero',
    'og-meta' =>  $user->photo_path,
    'content' => "<div class=\"news-one-hero__wrap\" style=\"background-image: linear-gradient(rgba(223, 224, 224, .1), rgba(255, 255, 255, 1)); filter: blur(3px);\"></div>"
];

?>
<article class="news-one-info">
    <div class="container">
        <?php if ($fullName = $user->getFullName($currentLanguage)): ?>
            <h1><?php echo Html::encode($fullName); ?></h1>
        <?php endif; ?>

        <?php if (!empty($position = $user->getPosition($currentLanguage))) : ?>
            <div class="user-h2"><?= $position ?></div>
        <?php endif ?>

        <section class="news-one-news">
            <div class="articles__item-img">
                <img src="<?= $thumb ?>">
            </div>

            <?php if (!empty($fullInfo = $user->getInfo($currentLanguage, 'full'))) : ?>
                <p><?= $fullInfo ?></p>
            <?php endif ?>
            
        </section>
    </div>
</article>




