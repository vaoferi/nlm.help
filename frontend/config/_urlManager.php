<?php

return [
    'class' => 'codemix\localeurls\UrlManager',
    'languages' =>
        [
            // Map 'uk' URL prefix to internal 'ru' language
            'uk' => 'ru',
            'en',
            'de'
        ],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [



        // Pages
        ['pattern' => 'page/<slug>', 'route' => 'page/view'],

        // Articles
        ['pattern' => 'articles', 'route' => 'article/index'],
        ['pattern' => 'article/donate', 'route' => 'article/donate'],
        ['pattern' => 'article/attachment-download', 'route' => 'article/attachment-download'],

        // Albums
        ['pattern' => 'albums', 'route' => 'album/index'],
        ['pattern' => 'album/<id>', 'route' => 'album/view'],

        //Projects
        ['pattern' => 'project/donate', 'route' => 'project/donate'],
        ['pattern' => 'project/attachment-download', 'route' => 'project/attachment-download'],
        ['pattern' => 'projects', 'route' => 'project/index'],
        ['pattern' => 'project/<slug>', 'route' => 'project/view'],


        // Site
        // ['pattern' => '/frontend/web/ru', 'route' => 'site/index', 'defaults' => ['language' => 'ru']],
        // ['pattern' => '/ru/frontend/web/ru', 'route' => 'site/index', 'defaults' => ['language' => 'ru']],
        ['pattern' => 'about', 'route' => 'site/about'],
        ['pattern' => 'contacts', 'route' => 'site/contact'],
        ['pattern' => 'donate', 'route' => 'site/donate'],
        ['pattern' => 'videos', 'route' => 'site/videos'],
        ['pattern' => 'testimonials', 'route' => 'site/testimonials'],
        ['pattern' => 'partners', 'route' => 'site/partners'],
        ['pattern' => 'rss', 'route' => 'site/rss'],
        ['pattern' => 'smi', 'route' => 'smi/index'],
        ['pattern' => '/', 'route' => 'site/index'],


        //hardcore
        ['pattern' => 'article/<slug>', 'route' => 'article/view'],
        ['pattern' => '<slug>', 'route' => 'article/category'],
        ['pattern' => 'user/<slug>', 'route' => 'article/view-user'],
        // Sitemap
        ['pattern' => 'sitemap.xml', 'route' => 'site/sitemap', 'defaults' => ['format' => 'xml']],
        ['pattern' => 'sitemap.txt', 'route' => 'site/sitemap', 'defaults' => ['format' => 'txt']],
        ['pattern' => 'sitemap.xml.gz', 'route' => 'site/sitemap', 'defaults' => ['format' => 'xml', 'gzip' => true]],
    ]
];
