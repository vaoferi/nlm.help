<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */

use yii\base\Application;
use yii\base\Event;

// Redirect legacy "/ru/..." URLs to canonical "/uk/..." with 301
Event::on(\yii\web\Application::class, Application::EVENT_BEFORE_REQUEST, function () {
    $request = Yii::$app->getRequest();
    $pathInfo = $request->getPathInfo(); // no leading slash

    // Match "ru" at the start of the path (e.g., "ru", "ru/...")
    if (preg_match('~^ru(?:/|$)~i', $pathInfo)) {
        $rest = substr($pathInfo, 2); // remove 'ru'
        if ($rest !== '' && $rest[0] !== '/') {
            $rest = '/' . $rest;
        }

        $newPath = '/uk' . $rest; // prepend uk
        $newUrl = $request->getBaseUrl() . $newPath;
        if ($query = $request->getQueryString()) {
            $newUrl .= '?' . $query;
        }

        Yii::$app->getResponse()->redirect($newUrl, 301)->send();
        Yii::$app->end();
    }
});
