<?php
/**
 * Created by PhpStorm.
 * User: rex
 * Date: 08.01.19
 * Time: 11:46
 */

namespace common\base;


class DateSetup
{
    const DATE_FORMAT = 'php:Y-m-d';
    const DATETIME_FORMAT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT = 'php:H:i:s';

    /**
     * @param $dateStr
     * @param string $type
     * @param null $format
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function convert($dateStr, $type = 'date', $format = null)
    {
        if ($type === 'datetime') {
            $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
        } elseif ($type === 'time') {
            $fmt = ($format == null) ? self::TIME_FORMAT : $format;
        } else {
            $fmt = ($format == null) ? self::DATE_FORMAT : $format;
        }
        return \Yii::$app->formatter->asDate($dateStr, $fmt);
    }
}