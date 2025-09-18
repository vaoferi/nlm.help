<?php

namespace frontend\controllers;

use cheatsheet\Time;
use common\models\Article;
use common\models\HelpCenter;
use common\models\Partner;
use common\models\PartnerOrder;
use common\models\Project;
use common\models\ProjectOrder;
use common\models\Slider;
use common\models\Smi;
use common\models\Testimonial;
use common\models\User;
use common\models\Video;
use common\sitemap\UrlsIterator;
use frontend\models\ContactForm;
use frontend\models\PartnerResource;
use frontend\models\ServiceDonateForm;
use Sitemaped\Element\Urlset\Urlset;
use Sitemaped\Sitemap;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\PageCache;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use rexit\liqpay\PaymentModel;

/**
 * Site controller
 */
class SiteController extends \frontend\controllers\Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => PageCache::class,
                'only' => ['sitemap'],
                'duration' => Time::SECONDS_IN_AN_HOUR,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0xd9d5c6,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class' => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $posts = Article::find()
            ->published()
            ->andWhere(['about_us' => false])
            ->withoutEmptyLang('title')
            ->limit(6)
            ->orderBy(['published_at' => SORT_DESC])
            ->all();
        $sliders = Slider::find()->all();
//        $postsAboutUs = Article::find()
//            ->withoutEmptyLang('title')
//            ->published()->aboutUs()->orderBy(['published_at' => SORT_DESC])->limit(2)
//            ->all();
        $smi = new ActiveDataProvider([
            'query' => Smi::find()
                ->orderBy(['updated_at' => SORT_DESC])
                ->limit(8),
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
//                    'title' => SORT_ASC,
                ]
            ],
        ]);

        $idx = ProjectOrder::getOrder();
        $projects = Project::find()
            ->withoutEmptyLang('title')
            ->active()->specOrder($idx)->limit(2)->all();

        $partnerIdx = PartnerOrder::getOrder();
        $partners = Partner::find()
            ->withoutEmptyLang('name')
            ->active()->specOrder($partnerIdx)->limit(8)->all();

        $testimonials = Testimonial::find()
            ->withoutEmptyLang('title')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->all();

        $videos = Video::find()->orderBy(['id' => SORT_DESC])
            ->withoutEmptyLang('embed_code')
            ->limit(6)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        return $this->renderLang('index', [
            'threePosts' => $posts,
//            'twoPostsAboutUs' => $postsAboutUs,
            'smi' => $smi,
            'projects' => $projects,
            'partners' => $partners,
            'testimonials' => $testimonials,
            'videos' => $videos,
            'sliders' => $sliders,
        ]);
    }

    /**
     * @return string
     */
    public function actionPartners()
    {
        $order = PartnerOrder::getOrder();

        $partnersQuery = Partner::find()
            ->withoutEmptyLang('name')
            ->with('articlePartners')
            ->with('partnerProjects')
            ->specOrder($order)->active();
        $pagination = new Pagination([
            'totalCount' => $partnersQuery->count(),
        ]);
        $partners = $partnersQuery
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->with('articlePartners')
            ->with('partnerProjects')
            ->all();
        return $this->render('partners', [
            'partners' => $partners,
            'pagination' => $pagination
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->contact()) {
            return $this->refresh();
        }

        return $this->render('contact', [
            'models' => HelpCenter::find()->with('projects')->with('articles')->with('helpCenterServices')->all(),
            'contactForm' => $model
        ]);
    }

    /**
     * @param string $format
     * @param bool $gzip
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionSitemap($format = 'xml', $gzip = false)
    {
        $links = new UrlsIterator();
        $sitemap = new Sitemap(new Urlset($links));

        Yii::$app->response->format = Response::FORMAT_RAW;

        if ($gzip === true) {
            Yii::$app->response->headers->add('Content-Encoding', 'gzip');
        }

        if ($format === 'xml') {
            Yii::$app->response->headers->add('Content-Type', 'application/xml');
            $content = $sitemap->toXmlString($gzip);
        } else if ($format === 'txt') {
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
            $content = $sitemap->toTxtString($gzip);
        } else {
            throw new BadRequestHttpException('Unknown format');
        }

        $linksCount = $sitemap->getCount();
        if ($linksCount > 50000) {
            Yii::warning(\sprintf('Sitemap links count is %d'), $linksCount);
        }

        return $content;
    }

    /**
     * @return string
     */
    public function actionVideos()
    {
        $videosQuery = Video::find()
            ->withoutEmptyLang('embed_code')
            ->orderBy(['created_at' => SORT_DESC]);

        $pagination = new Pagination([
            'totalCount' => $videosQuery->count(),
            'pageSize' => 9
        ]);
        $videos = $videosQuery
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();
        return $this->render('videos', [
            'models' => $videos,
            'pagination' => $pagination
        ]);
    }

    public function actionTestimonials()
    {
        $testimonialsQuery = Testimonial::find()
            ->orderBy(['created_at' => SORT_DESC]);
        $testimonialsQuery->withoutEmptyLang('title');
        $pagination = new Pagination([
            'totalCount' => $testimonialsQuery->count(),
        ]);
        $testimonialsQuery->limit($pagination->limit)
            ->offset($pagination->offset);
        $models = $testimonialsQuery->all();
        return $this->render('testimonials', [
            'models' => $models,
            'pagination' => $pagination
        ]);
    }

    public function actionAbout()
    {
        //should be loaded photo, selected 'display' on site
        $users = User::find()
            ->leftJoin('{{%user_social_network}}', '{{%user_social_network}}.user_id=user.id')
            ->where(['display' => User::DISPLAY_TRUE, 'status' => User::STATUS_ACTIVE])
            ->andWhere(['NOT', ['photo_base_url' => null]])
            ->andWhere(['NOT', ['photo_path' => null]])
            ->all();

        return $this->renderLang('about', [
            'users' => $users,
            'currentLanguage' => \Yii::$app->language,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDonate()
    { /*
                $model = new ServiceDonateForm();
                $model->payment_system = 'liqpay';

                $liqpay = new PaymentModel([
                    'public_key' => 'i69391837367',
                    'private_key' => '3GW5TmJjT95bB387Xx9ZweWTaV67f8jFHYi17i18',
                    'language' => (Yii::$app->language ==='ru')?'ru':'en',
                    'order_id' => implode("_", [
                        $order->order_type,
                        $order->id
                    ]),
                    'amount' => $order->amount,
        //    'currency' => Yii::$app->formatter->currencyCode,
                    'currency' => (Yii::$app->language ==='ru')?PaymentModel::CURRENCY_UAH:PaymentModel::CURRENCY_USD,
                    'description' => Yii::t('frontend', 'Donate from: {name} #{number}', [
                        'name' => $order->full_name,
                        'number' => $order->id
                    ]),
                    'action' => PaymentModel::ACTION_PAY_DONATE,
                    'sandbox' => YII_ENV_DEV ? '1' : '0',
                    'server_url' => Url::to(['/payment/liqpay-ipn'], 'https')
                ]);
        //        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
        //            if ($order = $model->createOrder()) {
        //                $sign = Yii::$app->security->hashData(json_encode(['order_id' => $order->id, 'type' => 'service']), Yii::$app->params['signKey']);
        //                return $this->redirect(['payment/' . $model->payment_system, 'sign' => $sign]);
        //            }
        //        }
        return $this->render('donate_new', compact('model', 'liqpay'));
        */
        return $this->render('donate_10_2020');
    }

    public function actionRss()
    {
        $articles = Article::find()
            ->leftJoin('{{%article_category}}', 'article.category_id=article_category.id')
            ->published()
            ->andWhere(['about_us' => false])
            ->withoutEmptyLang('title')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(10);

        $dataProvider = new ActiveDataProvider([
            'query' => $articles,
        ]);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');
        $currentLanguage = \Yii::$app->language;

        echo \Zelenin\yii\extensions\Rss\RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => function ($widget, \Zelenin\Feed $feed) {
                    $feed->addChannelTitle(Yii::$app->name);
                },
                'link' => Url::toRoute('/', true),
                'description' => Yii::t('frontend', '"New Life - International mission" News'),
                'language' => function ($widget, \Zelenin\Feed $feed) {
                    return Yii::$app->language;
                },
                'image' => function ($widget, \Zelenin\Feed $feed) use ($currentLanguage) {
                    $languages = \Yii::$app->params['availableLocales'];
                    $imageSrc = Url::to('@web/img/content/logo.png', true);
                    if (in_array($currentLanguage, $languages)) {
                        if ($currentLanguage != 'en') {
                            if (file_exists(\Yii::getAlias("@frontend/web/img/content/logo-$currentLanguage.png"))) {
                                $logo = '@web/img/content/logo-' . "{$currentLanguage}.png";
                                $imageSrc = Url::to($logo, true);
                            }
                        }
                    }
                    $feed->addChannelImage($imageSrc, Url::toRoute('/', true) ,240, 58, 'New Life - International mission');
                },
            ],
            'items' => [
                'title' => function (Article $article, $widget, \Zelenin\Feed $feed) {
                    if ($article->thumbnail !== null) {
                        $image = \Intervention\Image\ImageManagerStatic::make(Yii::getAlias('@storage/web/source') . $article->thumbnail_path);
                        $articlePhotoUrl = Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $article->thumbnail_path], true);
                        $feed->addItemEnclosure($articlePhotoUrl, $image->filesize(), "image/jpeg");
                    }

                    if ($article->category_id !== null) {
                        $feed->addItemCategory($article->category->title);
                    }

                    return $article->title;
                },
                'description' => function (Article $article) {
                    return $article->short_description;
                },
                'link' => function (Article $article) {
                    return Url::toRoute(['article/view', 'slug' => $article->slug], true);
                },
                'author' => function (Article $article) {
                    $authorName = '';
                    if ($article->author->userProfile && $article->author->userProfile->getFullName()) {
                        $authorName = $article->author->userProfile->getFullName();
                    }
                    return $authorName;
                },
                'guid' => function (Article $article) {
                    return Url::toRoute(['article/view', 'slug' => $article->slug], true);
                },
                'pubDate' => function (Article $article) {
                    return date(DATE_RSS, $article->created_at);
                },

            ]
        ]); exit;
    }
}
