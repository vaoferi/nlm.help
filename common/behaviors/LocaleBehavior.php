<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Application;

/**
 * Class LocaleBehavior
 * @package common\behaviors
 */
class LocaleBehavior extends Behavior
{
    /**
     * @var string
     */
    public $cookieName = '_locale';

    /**
     * @var bool
     */
    public $enablePreferredLanguage = true;

    /**
     * @return array
     */
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest'
        ];
    }

    /**
     * Resolve application language by checking user cookies, preferred language and profile settings
     */
    public function beforeRequest()
    {
        $request = Yii::$app->getRequest();

        // Let codemix\localeurls manage language entirely on the frontend
        // to avoid conflicts (e.g., EN falling back to UA due to cookie).
        $urlManager = Yii::$app->getUrlManager();
        if (Yii::$app->id === 'frontend' && $urlManager instanceof \codemix\localeurls\UrlManager && $urlManager->enableLocaleUrls) {
            return;
        }

        $hasCookie = $request->getCookies()->has($this->cookieName);
        $forceUpdate = Yii::$app->session->hasFlash('forceUpdateLocale');
        if ($hasCookie && !$forceUpdate) {
            $locale = $request->getCookies()->getValue($this->cookieName);
        } else {
            $locale = $this->resolveLocale();
        }
        Yii::$app->language = $locale;
    }

    public function resolveLocale()
    {
        $locale = Yii::$app->language;

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->userProfile->locale) {
            $locale = Yii::$app->user->getIdentity()->userProfile->locale;
        } elseif ($this->enablePreferredLanguage) {
            $locale = Yii::$app->request->getPreferredLanguage($this->getAvailableLocales());
        }

        return $locale;
    }

    /**
     * @return array
     */
    protected function getAvailableLocales()
    {
        return array_keys(Yii::$app->params['availableLocales']);
    }
}
