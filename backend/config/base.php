<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'layout' => 'hyper',
    'components' => [
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php')
    ],
    'params' => [
        'availableLocales' => [
            // Code 'ru' використовується для українського контенту. Показуємо ярлик 'ua'.
            'ru' => 'ua',
            'en' => 'en',
            'de' => 'de',
        ],
        // WYSIWYG editor for backend forms: 'redactor' or 'tinymce'
        'editor' => 'redactor',
    ],
];
