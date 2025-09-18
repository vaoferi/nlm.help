<?php
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE = edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="New life International mission">
    <meta name="description" content="New life International mission">
    <link rel="shortcut icon" href="/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon/android-chrome-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16">
    <meta name="msapplication-TileImage" content="/img/favicon/mstile-150x150.png">
    <meta name="msapplication-TileImage" content="/img/favicon/mstile-310x150.png">
    <meta name="msapplication-TileImage" content="/img/favicon/mstile-70x70.png">
    <meta name="theme-color" content="#000">
    <meta name="msapplication-TileColor" content="#000">
    <meta name="msapplication-navbutton-color" content="#000">
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?= Yii::$app->name ?>">
    <title><?php echo Html::encode(implode(' - ', array_filter([
            Yii::$app->name,
            $this->title
        ]))) ?></title>
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
    <?= \common\widgets\DbText::widget(['key' => 'meta_head']) ?>
</head>
<body>
<?= \common\widgets\DbText::widget(['key' => 'analytics']) ?>
<?php $this->beginBody() ?>
    <?php echo $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
