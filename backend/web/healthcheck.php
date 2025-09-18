<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Paths
$root = __DIR__ . '/../../';

$out = [];

// Vendor
$vendorOk = file_exists($root . 'vendor/autoload.php');
$out[] = 'vendor=' . ($vendorOk ? 'ok' : 'missing');
if ($vendorOk) {
    require $root . 'vendor/autoload.php';
}

// Yii core class
if (file_exists($root . 'vendor/yiisoft/yii2/Yii.php')) {
    require $root . 'vendor/yiisoft/yii2/Yii.php';
    $out[] = 'yii=loaded';
} else {
    $out[] = 'yii=missing';
}

// .env
try {
    require $root . 'common/env.php';
    $out[] = 'env=loaded';
} catch (Throwable $e) {
    $out[] = 'env=error:' . $e->getMessage();
}

// Bootstrap
try {
    require $root . 'common/config/bootstrap.php';
    require $root . 'backend/config/bootstrap.php';
    $out[] = 'bootstrap=ok';
} catch (Throwable $e) {
    $out[] = 'bootstrap=error:' . $e->getMessage();
}

// Check ADMIN_THEME
$out[] = 'ADMIN_THEME=' . ((getenv('ADMIN_THEME') !== false && getenv('ADMIN_THEME') !== '') ? getenv('ADMIN_THEME') : '(empty)');

// Check Hyper alias
$alias = null;
try {
    $alias = Yii::getAlias('@hyperAssets', false);
} catch (Throwable $e) {
    $alias = null;
}
$out[] = '@hyperAssets=' . ($alias ?: '(unset)');
$out[] = 'hyper_dir=' . (($alias && is_dir($alias)) ? 'exists' : 'missing');

// Try to build Yii application and open DB
try {
    $config = \yii\helpers\ArrayHelper::merge(
        require $root . 'common/config/base.php',
        require $root . 'common/config/web.php',
        require $root . 'backend/config/base.php',
        require $root . 'backend/config/web.php'
    );
    $app = new yii\web\Application($config);
    $app->db->open();
    $out[] = 'app=booted';
    $out[] = 'db=connected';
} catch (Throwable $e) {
    $out[] = 'app=error:' . $e->getMessage();
}

// Output text/plain
header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out), "\n";
