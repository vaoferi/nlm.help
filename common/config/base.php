<?php

use kartik\datecontrol\Module;

$config = [
    'name' => 'New Life',
    'vendorPath' => __DIR__ . '/../../vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language' => 'en',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'datecontrol' => [
            'class' => 'kartik\\datecontrol\\Module',
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d',
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            'autoWidget' => true,
        ]
    ],
    'components' => [
        'posting' => [
            'class' => \common\components\social\PostingComponent::class,
            'tokenStorage' => \common\models\TokenStorage::class,
            'clients' => [
                // Only Facebook client kept
                'fb' => [
                    'class' => \common\components\social\FbClient::class,
                    'group_id' => 259384167473055,
                ],
            ]
        ],
        'liqPay' => [
            'class' => \common\components\payment\liqpay\LiqPay::class,
            'public_key' => 'i69391837367',
            'private_key' => '3GW5TmJjT95bB387Xx9ZweWTaV67f8jFHYi17i18',
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}'
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
            'cachePath' => '@common/runtime/cache'
        ],
        'commandBus' => [
            'class' => trntv\bus\CommandBus::class,
            'middlewares' => [
                [
                    'class' => trntv\bus\middlewares\BackgroundCommandMiddleware::class,
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],
        'formatter' => [
            'class' => yii\i18n\Formatter::class,
            'dateFormat' => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'currencyCode' => 'UAH',
        ],
        'glide' => [
            'class' => trntv\glide\components\Glide::class,
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY')
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => env('ADMIN_EMAIL')
            ]
        ],
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}'
                ]
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                ],
                '*' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                        'backend' => 'backend.php',
                        'frontend' => 'frontend.php',
                    ],
                    'on missingTranslation' => [backend\modules\translation\Module::class, 'missingTranslation']
                ],
            ],
        ],
        'fileStorage' => [
            'class' => trntv\filekit\Storage::class,
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => common\components\filesystem\LocalFlysystemBuilder::class,
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => common\behaviors\FileStorageLogBehavior::class,
                'component' => 'fileStorage'
            ]
        ],
        'keyStorage' => [
            'class' => common\components\keyStorage\KeyStorage::class
        ],
        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('BACKEND_HOST_INFO'),
                'baseUrl' => env('BACKEND_BASE_URL'),
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('FRONTEND_HOST_INFO'),
                'baseUrl' => env('FRONTEND_BASE_URL'),
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('STORAGE_HOST_INFO'),
                'baseUrl' => env('STORAGE_BASE_URL'),
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        ),
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@common/runtime/queue',
        ],
    ],
    'params' => [
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'signKey' => env('PAYMENT_SIGN_KEY'),
        'bsVersion' => '5.x',
        'availableLocales' => [
            'ru' => 'ru',
            'en' => 'en',
            'de' => 'de',
        ],
        'defaultLanguage' => 'ru',
        'acceptProviders' => [
            'youtube'
        ],
        'fb' => [
            'version' => 'v3.3',
            'permissions' => ['email', 'manage_pages', 'publish_pages', 'pages_messaging', 'pages_show_list', 'pages_manage_cta', 'pages_manage_instant_articles'],
            'redirectUri' => 'https://admin.nlm.help/auth/fb-callback',
            'appId' => 415784542347891,
            'secretKey' => 'a0cf072234142df99fd588481fb2e134',
        ]
    ],
];

if (YII_ENV_PROD) {
    // you can enable email log target here if required
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class
    ];

    $config['components']['cache'] = [
        'class' => yii\caching\DummyCache::class
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => env('SMTP_HOST'),
        'port' => env('SMTP_PORT'),
        'username' => env('SMTP_USERNAME'),
        'password' => env('SMTP_PASSWORD'),
        'encryption' => env('SMTP_ENCRYPTION'),
    ];
}

return $config;
