<?php
namespace backend\assets;

use yii\web\AssetBundle;

class HyperAsset extends AssetBundle
{
    // Use alias configured in backend/config/bootstrap.php for Hyper assets
    public $sourcePath = '@hyperAssets';

    public $css = [
        'vendor.min.css',
        'vendor/flatpickr/flatpickr.min.css',
        'vendor/daterangepicker/daterangepicker.css',
        'css/app.min.css',
    ];

    public $js = [
        'js/vendor.min.js',
        'vendor/moment/moment.min.js',
        'vendor/daterangepicker/daterangepicker.js',
        'vendor/flatpickr/flatpickr.min.js',
        'js/app.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
