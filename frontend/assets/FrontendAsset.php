<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use common\assets\Html5shiv;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Frontend application asset
 */
class FrontendAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@frontend/web';

    /**
     * @var array
     */
    public $css = [
        'css/swiper-bundle.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
//        'css/swiper.min.css',
        'css/main.css',
        'css/style.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/libs.min.js',
        'libs/slick/slick.min.js',
        'libs/masonry/masonry.min.js',
        'libs/fancybox/jquery.fancybox.min.js',
        'libs/nouislider/nouislider.js',
//        'libs/swiper.min.js',
        'libs/swiper-bundle.min.js',
        'js/common.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        Html5shiv::class,
    ];
}
