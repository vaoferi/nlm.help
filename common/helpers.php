<?php
/**
 * Yii2 Shortcuts
 * @author Eugene Terentev <eugene@terentev.net>
 * -----
 * This file is just an example and a place where you can add your own shortcuts,
 * it doesn't pretend to be a full list of available possibilities
 * -----
 */

/**
 * @return int|string
 */
function getMyId()
{
    return Yii::$app->user->getId();
}

/**
 * @param string $view
 * @param array $params
 * @return string
 */
function render($view, $params = [])
{
    return Yii::$app->controller->render($view, $params);
}

/**
 * @param $url
 * @param int $statusCode
 * @return \yii\web\Response
 */
function redirect($url, $statusCode = 302)
{
    return Yii::$app->controller->redirect($url, $statusCode);
}

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null)
{

    $value = getenv($key) ?? $_ENV[$key] ?? $_SERVER[$key];

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;

        case 'false':
        case '(false)':
            return false;
    }

    return $value;
}

/**
 * This function returns the maximum files size that can be uploaded
 * in PHP
 * @return mixed
 */
function uploadMaxSize() {
    return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));
}

/**
 * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
 * @param $sSize
 * @return int
 */
function convertPHPSizeToBytes($sSize) {
    $sSuffix = strtoupper(substr($sSize, -1));
    if (!in_array($sSuffix,array('P','T','G','M','K'))){
        return (int)$sSize;
    }
    $iValue = substr($sSize, 0, -1);
    switch ($sSuffix) {
        case 'P':
            $iValue *= 1024;
        // Fallthrough intended
        case 'T':
            $iValue *= 1024;
        // Fallthrough intended
        case 'G':
            $iValue *= 1024;
        // Fallthrough intended
        case 'M':
            $iValue *= 1024;
        // Fallthrough intended
        case 'K':
            $iValue *= 1024;
            break;
    }
    return (int)$iValue;
}

/**
 * @param mixed ...$vars
 */
function dump($vars) {
    \yii\helpers\VarDumper::dump($vars, 10, 1);
}

/**
 * @return mixed
 */
function getLanguages() {
    return Yii::$app->params['availableLocales'];
}

function getDefaultLanguage() {
    return Yii::$app->params['defaultLanguage'];
}