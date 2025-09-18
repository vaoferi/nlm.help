<?php
/**
 * Created by PhpStorm.
 * User: kharalampidi
 * Date: 11.03.19
 * Time: 14:11
 */

namespace common\widgets;


use yii\base\Widget;
use yii\helpers\Html;

class LangLogoWidget extends Widget
{
    /* img tag options */
    public $options = [];

    public $defaultLanguage = 'en';

    /**
     * @return string
     */
    public function run()
    {
        $languages = \Yii::$app->params['availableLocales'];
        $currentLanguage = \Yii::$app->language;
        if (array_key_exists ($currentLanguage, $languages)) {
        // if (in_array($currentLanguage, $languages)) {
            if ($currentLanguage != $this->defaultLanguage) {
                if (file_exists(\Yii::getAlias("@frontend/web/img/content/logo-$currentLanguage.png"))) {
                    return Html::img("/img/content/logo-$currentLanguage.png", $this->options);
                }
            }
        }
        return Html::img('/img/content/logo.png', $this->options);
    }
}