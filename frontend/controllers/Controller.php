<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace frontend\controllers;

use yii\helpers\Html;

class Controller extends \yii\web\Controller
{
    public $defaultLanguage = 'en';

    public function renderLang($view, $params = [])
    {
        $languages = \Yii::$app->params['availableLocales'];
        $currentLanguage = \Yii::$app->language;

        if (array_key_exists ($currentLanguage, $languages)) {
//        if (in_array($currentLanguage, $languages)) {
            if ($currentLanguage != $this->defaultLanguage) {
                try {
//die('stop1');
                    return parent::render($view . '_' . $currentLanguage, $params);
                } catch (\Exception $e) {}
            }
        }
//die('stop 2');
        return parent::render($view, $params);
    }

    public function renderLangPartial($view, $params = [])
    {
        $languages = \Yii::$app->params['availableLocales'];
        $currentLanguage = \Yii::$app->language;
        if (array_key_exists ($currentLanguage, $languages)) {
//        if (in_array($currentLanguage, $languages)) {
            if ($currentLanguage != $this->defaultLanguage) {
                try {
                    return parent::renderPartial($view . '_' . $currentLanguage, $params);
                } catch (\Exception $e) {}
            }
        }
        return parent::renderPartial($view, $params);
    }
}