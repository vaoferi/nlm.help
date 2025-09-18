<?php

namespace common\helpers;

use Yii;

class MultilingualHelper
{
    /**
     * @param $fieldName string
     * @param $language string
     * @return string
     */
    public static function getFieldName($fieldName, $language)
    {
        if ($language !== Yii::$app->language) {
            return $fieldName . '_' . self::getLanguageBaseName($language);
        }
        return $fieldName;
    }

    /**
     * @param $language string
     * @return string
     */
    public static function getLanguageBaseName($language)
    {
        return substr($language, 0, 2);
    }

    /**
     * @param $language string
     * @return string
     */
    public static function getLanguageISOName($language)
    {
        return substr($language, 3);
    }
}