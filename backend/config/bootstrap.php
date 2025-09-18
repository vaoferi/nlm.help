<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
// Resolve Hyper assets path for both local (repo root) and shared hosting (inside public_html)
$pubRoot = dirname(__DIR__, 2); // .../public_html
$candidates = [
    $pubRoot . '/Hyper_v5.5.0/Admin/dist/assets',           // preferred: inside public_html
    dirname($pubRoot) . '/Hyper_v5.5.0/Admin/dist/assets',  // fallback: repo root
];
$found = false;
foreach ($candidates as $p) {
    if (is_dir($p)) {
        \Yii::setAlias('@hyperAssets', $p);
        $found = true;
        break;
    }
}
// If not found, disable Hyper layout via env to avoid fatal errors
if (!$found) {
    if (function_exists('putenv')) {
        putenv('ADMIN_THEME=');
    }
    $_ENV['ADMIN_THEME'] = '';
    $_SERVER['ADMIN_THEME'] = '';
}

// Backend safety shim: if Bootstrap 5 ActiveForm is missing, alias to core ActiveForm
if (!class_exists('yii\\bootstrap5\\ActiveForm', false)) {
    class_alias('yii\\widgets\\ActiveForm', 'yii\\bootstrap5\\ActiveForm');
}
