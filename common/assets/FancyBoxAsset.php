<?php
/**
 * Created by PhpStorm.
 * User: rex
 * Date: 14.01.19
 * Time: 11:47
 */

namespace common\assets;


use yii\web\AssetBundle;

class FancyBoxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fancyapps/fancybox';
    public $css = [
        'source/jquery.fancybox.css'
    ];
    public $js = [
        'source/jquery.fancybox' . (!YII_DEBUG ? '.pack' : '') . '.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}