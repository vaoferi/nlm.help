<?php
/**
 * Require core files
 */
require_once(__DIR__ . '/../helpers.php');

/**
 * Setting path aliases
 */
Yii::setAlias('@base', realpath(__DIR__ . '/../../'));
Yii::setAlias('@common', realpath(__DIR__ . '/../../common'));
Yii::setAlias('@api', realpath(__DIR__ . '/../../api'));
Yii::setAlias('@frontend', realpath(__DIR__ . '/../../frontend'));
Yii::setAlias('@backend', realpath(__DIR__ . '/../../backend'));
Yii::setAlias('@console', realpath(__DIR__ . '/../../console'));
Yii::setAlias('@storage', realpath(__DIR__ . '/../../storage'));
Yii::setAlias('@tests', realpath(__DIR__ . '/../../tests'));

/**
 * Setting url aliases
 */
Yii::setAlias('@apiUrl', env('API_HOST_INFO') . env('API_BASE_URL'));
Yii::setAlias('@frontendUrl', env('FRONTEND_HOST_INFO') . env('FRONTEND_BASE_URL'));
Yii::setAlias('@backendUrl', env('BACKEND_HOST_INFO') . env('BACKEND_BASE_URL'));
Yii::setAlias('@storageUrl', env('STORAGE_HOST_INFO') . env('STORAGE_BASE_URL'));


/**
 * Overrides
 */
Yii::$classMap['omgdef\multilingual\MultilingualTrait'] = realpath(__DIR__ . '/../base/MultilingualTrait.php');
Yii::$classMap['yii\imperavi\VideoImperaviRedactorPluginAsset'] = realpath(__DIR__ . '/../assets/VideoImperaviRedactorPluginAsset.php');

// Bootstrap compatibility shims (map old yii\bootstrap classes to BS5/core)
if (!class_exists('yii\bootstrap\ActiveForm', false)) {
    class_alias('yii\widgets\ActiveForm', 'yii\bootstrap\ActiveForm');
}
if (class_exists('yii\bootstrap5\Nav') && !class_exists('yii\bootstrap\Nav', false)) {
    class_alias('yii\bootstrap5\Nav', 'yii\bootstrap\Nav');
}
if (class_exists('yii\bootstrap5\BootstrapAsset') && !class_exists('yii\bootstrap\BootstrapAsset', false)) {
    class_alias('yii\bootstrap5\BootstrapAsset', 'yii\bootstrap\BootstrapAsset');
}
if (class_exists('yii\bootstrap5\BootstrapPluginAsset') && !class_exists('yii\bootstrap\BootstrapPluginAsset', false)) {
    class_alias('yii\bootstrap5\BootstrapPluginAsset', 'yii\bootstrap\BootstrapPluginAsset');
}
