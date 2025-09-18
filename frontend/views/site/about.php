<?php

use common\widgets\LangLogoWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $users \common\models\User[] */
$this->params['custom_header'] = [
    'class' => 'albulm-hero about-us-hero',
    'content' => $this->render('_header_slider_about'),
];

$impactStats = [
    [
        'value' => '40 000+',
        'label' => Yii::t('frontend', 'people heard about God through mission projects'),
    ],
    [
        'value' => '940',
        'label' => Yii::t('frontend', 'individuals transformed their lives with the support of the mission'),
    ],
    [
        'value' => '12',
        'label' => Yii::t('frontend', 'regional branches operate across Ukraine'),
    ],
];

$timeline = [
    [
        'year' => '2010',
        'items' => [
            Yii::t('frontend', 'Beginning of the ministry to the homeless of Fedor Gerasimov'),
            Yii::t('frontend', 'Beginning of the ministry in prisons as chaplains'),
        ],
    ],
    [
        'year' => '2011',
        'items' => [
            Yii::t('frontend', 'Registration of Christian Mission "New Life"'),
        ],
    ],
    [
        'year' => '2013',
        'items' => [
            Yii::t('frontend', 'Start of a productive collaboration with media'),
        ],
    ],
    [
        'year' => '2014',
        'items' => [
            Yii::t('frontend', 'Beginning of a productive cooperation with the authorities accounting for the numbers of the homeless and the poor'),
            Yii::t('frontend', 'Begin working as volunteers at the heating points'),
            Yii::t('frontend', 'YMCA volunteers opened the ministry "Journey to Freedom" at the Rehabilitation Centre "New Life"'),
            Yii::t('frontend', 'Opening of a branch in Cherkassy'),
        ],
    ],
    [
        'year' => '2015',
        'items' => [
            Yii::t('frontend', 'Opening of the second branch in Cherkassy'),
            Yii::t('frontend', 'The organization began work in the Correctional Facilities No 51 and 74 of the city of Odessa where social and spiritual work was carried out with the convicts, humanitarian aid was also provided'),
            Yii::t('frontend', 'Project «Help to Survive» was started. Project representatives and volunteers organized the collection and distribution points for humanitarian assistance to socially vulnerable groups of the population'),
            Yii::t('frontend', 'The daily feeding of the homeless is started in front of the Railway Station (Pushkin square) under the name of the project "Share bread with the hungry"'),
        ],
    ],
    [
        'year' => '2016',
        'items' => [
            Yii::t('frontend', 'The heating points for the homeless people are deployed in Odessa. One of them is deployed in Primorskiy district on Starosnennaya Square. Another is deployed in Suvorovskiy district on Julio-Curie street. The Christian Mission "New Life" was invited as organizers'),
            Yii::t('frontend', 'Opening of a branch in Zaporizhia'),
        ],
    ],
    [
        'year' => '2017',
        'items' => [
            Yii::t('frontend', 'Opening of a shelter in the village Krasnoselka for the elderly people'),
            Yii::t('frontend', 'A rehabilitation center «New Life» in the village Velykiy Dalnik was opened'),
            Yii::t('frontend', 'Opening of a mission branch in Zaporizhia'),
            Yii::t('frontend', 'Beginning of the building of a house of mercy for the elderly in the city of Lubny'),
            Yii::t('frontend', 'Opening of a mission branch in Nikolaev for the project work "Help to Survive"'),
            Yii::t('frontend', 'Opening of a mission branch in Ochakov for the project work "Help to Survive"'),
            Yii::t('frontend', 'Opening of a mission branch in Pavlograd for the project work «Help to Survive» in the cities: Pavlograd, Poltava, Kiev, Arciz, Berezino, Kamenskoe, Dnieper, Ismail and Vinnitsa'),
            Yii::t('frontend', 'A rehabilitation center «New Life» in Zaporizhia'),
            Yii::t('frontend', 'Registration of New Life International Mission'),
        ],
    ],
    [
        'year' => '2019',
        'items' => [
            Yii::t('frontend', 'Opening of the project «New Life Creators» with New Life International Mission'),
        ],
    ],
];

$heroMenuItems = [
    [
        'label' => Yii::t('frontend', 'Our projects'),
        'url' => ['project/index'],
        'key' => 'projects',
    ],
    [
        'label' => Yii::t('frontend', 'Contacts'),
        'url' => ['site/contact'],
        'key' => 'contacts',
    ],
    [
        'label' => Yii::t('frontend', 'Media'),
        'url' => ['site/videos'],
        'key' => 'media',
    ],
    [
        'label' => Yii::t('frontend', 'About Us'),
        'url' => ['site/about'],
        'key' => 'about',
    ],
];

$languageList = Yii::$app->params['availableLocales'] ?? [];
$ctaUrl = Url::to(['site/donate']);

$this->registerCss(<<<CSS
.about-shell {
    background: #f2f6fb;
    padding: 0 0 96px;
}
.about-shell__inner {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 16px;
}
.about-hero {
    display: grid;
    gap: 32px;
    padding-top: 32px;
}
.about-hero__surface {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(15, 39, 60, 0.08);
    padding: 20px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}
.about-hero__brand {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 0 0 auto;
}
.about-hero__menu {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
    justify-content: center;
    flex: 1 1 auto;
}
.about-hero__controls {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 16px;
    flex: 0 0 auto;
    flex-wrap: wrap;
}
.about-hero__logo {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}
.about-hero__logo img {
    max-height: 42px;
    width: auto;
}
.about-hero__menu a {
    color: #17374f;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: color 0.2s ease;
}
.about-hero__menu a:hover,
.about-hero__menu a:focus {
    color: #102235;
}
.about-hero__menu a.is-active {
    color: #0f76bc;
}
.about-hero__cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 28px;
    background: #17374f;
    color: #ffffff;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 14px 32px rgba(23, 55, 79, 0.24);
}
.about-hero__cta:hover,
.about-hero__cta:focus {
    transform: translateY(-1px);
    box-shadow: 0 18px 40px rgba(23, 55, 79, 0.28);
}
.about-hero__lang {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f2f6fb;
    padding: 8px 14px;
    border-radius: 999px;
}
.about-hero__lang a {
    text-decoration: none;
    text-transform: lowercase;
    font-size: 0.9rem;
    color: #576779;
    font-weight: 600;
    transition: color 0.2s ease;
}
.about-hero__lang a.is-active {
    color: #17374f;
}
.about-shell__crumb {
    font-size: 0.9rem;
    color: #5c6c80;
}
.about-shell__intro {
    text-align: center;
    margin-bottom: 24px;
}
.about-shell__title {
    margin: 16px auto 12px;
    max-width: 880px;
    font-size: clamp(2.5rem, 2vw + 1.5rem, 3.25rem);
    line-height: 1.12;
    font-weight: 700;
    color: #17374f;
}
.about-shell__lead {
    max-width: 780px;
    margin: 0 auto;
    color: #3c4a5f;
    font-size: 1.125rem;
    line-height: 1.65;
}
.about-tabs {
    margin-top: 40px;
}
.about-tabs__nav {
    list-style: none;
    margin: 0;
    padding: 16px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(15, 39, 60, 0.08);
}
.about-tabs__item {
    display: flex;
}
.about-tabs__button {
    width: 100%;
    border: none;
    border-radius: 16px;
    background: #f4f6fb;
    color: #17374f;
    font-weight: 600;
    font-size: 1.05rem;
    padding: 16px 24px;
    line-height: 1.2;
    text-align: center;
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
}
.about-tabs__button:hover,
.about-tabs__button:focus {
    background: #e6ecf5;
}
.about-tabs__button.active {
    background: #17374f;
    color: #ffffff;
    box-shadow: 0 18px 36px rgba(23, 55, 79, 0.28);
}
.about-tabs__button:focus-visible {
    outline: 2px solid rgba(23, 55, 79, 0.55);
    outline-offset: 3px;
}
.about-tabs__content {
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 24px 54px rgba(15, 39, 60, 0.08);
    padding: 48px 56px;
    margin-top: 36px;
}
.about-overview {
    display: grid;
    gap: 32px;
    align-items: start;
}
.about-overview__text p {
    margin-bottom: 1rem;
    font-size: 1rem;
    line-height: 1.7;
    color: #3c4a5f;
}
.about-overview__text p:last-child {
    margin-bottom: 0;
}
.about-overview__stats {
    display: grid;
    gap: 18px;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
}
.about-overview__stat {
    background: #f2f7ff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 10px 24px rgba(15, 39, 60, 0.08);
}
.about-overview__stat-value {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: #17374f;
}
.about-overview__stat-label {
    display: block;
    margin-top: 8px;
    font-size: 0.95rem;
    line-height: 1.5;
    color: #4f5e72;
}
.about-awards {
    margin-top: 48px;
}
.about-awards__header {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 24px;
}
.about-awards__header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #17374f;
}
.about-awards__header p {
    margin: 0;
    color: #4f5e72;
}
.about-awards__slider {
    background: #f7f9fc;
    border-radius: 18px;
    padding: 24px;
}
.about-team {
    display: grid;
    gap: 40px;
}
.about-team__grid {
    display: grid;
    gap: 32px;
}
@media (min-width: 992px) {
    .about-team__grid {
        grid-template-columns: 1fr 1fr;
        align-items: start;
    }
}
.about-team__lead h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #17374f;
    margin-bottom: 16px;
}
.about-team__lead p {
    color: #3c4a5f;
    line-height: 1.65;
    margin-bottom: 1rem;
}
.about-team__quote {
    margin: 24px 0;
    padding: 20px 24px;
    border-left: 4px solid #17374f;
    background: #f2f7ff;
    color: #17374f;
    font-weight: 600;
    font-size: 1.1rem;
}
.about-team__resources {
    display: grid;
    gap: 24px;
}
.about-team__resources h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #17374f;
    margin-bottom: 16px;
}
.about-team__resources .about-us__info-wrap {
    position: relative;
    z-index: 2;
}
.about-history__header {
    margin-bottom: 32px;
}
.about-history__header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #17374f;
    margin-bottom: 12px;
}
.about-history__header p {
    margin: 0;
    color: #4f5e72;
}
.about-history__timeline {
    display: grid;
    gap: 24px;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
}
.about-history__year {
    background: #f7f9fc;
    border: 1px solid rgba(23, 55, 79, 0.12);
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 12px 26px rgba(15, 39, 60, 0.06);
}
.about-history__badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    border-radius: 18px;
    background: #17374f;
    color: #ffffff;
    font-size: 1.25rem;
    font-weight: 700;
}
.about-history__list {
    margin: 16px 0 0;
    padding-left: 18px;
    color: #3c4a5f;
    line-height: 1.6;
}
.about-history__list li {
    margin-bottom: 10px;
}
.about-history__list li:last-child {
    margin-bottom: 0;
}
@media (max-width: 991px) {
    .about-tabs__content {
        padding: 36px 32px;
    }
    .about-hero__surface {
        padding: 20px;
    }
}
@media (max-width: 767px) {
    .about-shell {
        padding-bottom: 72px;
    }
    .about-hero__surface {
        flex-direction: column;
        align-items: stretch;
    }
    .about-hero__menu {
        justify-content: center;
    }
    .about-hero__controls {
        width: 100%;
        justify-content: center;
    }
    .about-hero__cta {
        width: 100%;
    }
    .about-tabs__content {
        padding: 28px 24px;
    }
}
@media (max-width: 575px) {
    .about-hero__surface {
        padding: 18px;
    }
    .about-hero__menu {
        gap: 16px;
    }
    .about-tabs__nav {
        gap: 12px;
        padding: 12px;
    }
    .about-tabs__button {
        padding: 14px 18px;
        font-size: 1rem;
    }
}
CSS);

$this->registerJs(<<<JS
(function () {
    const tabButtons = document.querySelectorAll('[data-about-tab]');
    if (!tabButtons.length) {
        return;
    }
    const hashMap = {
        '#about-section': 'about',
        '#team-section': 'team',
        '#story-section': 'history'
    };
    const updateHash = (anchor) => {
        if (!anchor) {
            return;
        }
        if (history.replaceState) {
            history.replaceState(null, '', anchor);
        } else {
            window.location.hash = anchor;
        }
    };
    const triggerResize = () => {
        window.setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 50);
    };
    const showTab = (key) => {
        const target = document.querySelector('[data-about-tab="' + key + '"]');
        if (!target) {
            return;
        }
        if (window.bootstrap && bootstrap.Tab) {
            const instance = bootstrap.Tab.getInstance(target) || new bootstrap.Tab(target);
            instance.show();
        } else {
            const selector = target.getAttribute('data-bs-target');
            document.querySelectorAll('[data-about-tab]').forEach((btn) => {
                const paneSelector = btn.getAttribute('data-bs-target');
                const pane = paneSelector ? document.querySelector(paneSelector) : null;
                const isActive = btn === target;
                btn.classList.toggle('active', isActive);
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
                if (pane) {
                    pane.classList.toggle('active', isActive);
                    pane.classList.toggle('show', isActive);
                }
            });
            updateHash(target.getAttribute('data-anchor') || '#about-section');
            triggerResize();
        }
    };
    tabButtons.forEach((btn) => {
        btn.addEventListener('click', (event) => {
            if (!(window.bootstrap && bootstrap.Tab)) {
                event.preventDefault();
                showTab(btn.getAttribute('data-about-tab'));
            }
        });
        btn.addEventListener('shown.bs.tab', () => {
            const anchor = btn.getAttribute('data-anchor') || '#about-section';
            updateHash(anchor);
            triggerResize();
        });
    });
    const currentHash = window.location.hash;
    if (hashMap[currentHash]) {
        showTab(hashMap[currentHash]);
    }
})();
JS);
?>

<div class="about-shell">
    <div class="about-shell__inner">
        <div class="about-hero">
            <div class="about-hero__surface">
                <div class="about-hero__brand">
                    <?= Html::a(
                        LangLogoWidget::widget(),
                        Url::to(['/site/index']),
                        [
                            'class' => 'about-hero__logo',
                            'title' => Yii::t('frontend', 'New life - International mission'),
                        ]
                    ) ?>
                </div>
                <nav class="about-hero__menu" aria-label="<?= Html::encode(Yii::t('frontend', 'Main navigation')) ?>">
                    <?php foreach ($heroMenuItems as $item): ?>
                        <?php $isActive = $item['key'] === 'about'; ?>
                        <a href="<?= Url::to($item['url']) ?>" class="<?= $isActive ? 'is-active' : '' ?>">
                            <?= Html::encode($item['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
                <div class="about-hero__controls">
                    <a class="about-hero__cta" href="<?= $ctaUrl ?>">
                        <?= Html::encode(Yii::t('frontend', 'Help')) ?>
                    </a>
                    <?php if ($languageList): ?>
                        <div class="about-hero__lang" role="group" aria-label="<?= Html::encode(Yii::t('frontend', 'Change language')) ?>">
                            <?php foreach ($languageList as $code => $label): ?>
                                <?php $isActiveLang = $code === Yii::$app->language; ?>
                                <a href="<?= Url::to(array_merge([Yii::$app->controller->route], Yii::$app->request->get(), ['language' => $code])) ?>" class="<?= $isActiveLang ? 'is-active' : '' ?>">
                                    <?= Html::encode(mb_strtolower(mb_substr($code, 0, 2))) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="about-shell__intro">
                <div class="about-shell__crumb">
                    <?= Html::encode(sprintf('%s — %s', Yii::t('frontend', 'Home'), Yii::t('frontend', 'About us'))) ?>
                </div>
                <h1 class="about-shell__title">
                    <?= Yii::t('frontend', 'Christian Mission "New Life" unites people who love God and serve people.') ?>
                </h1>
                <p class="about-shell__lead">
                    <?= Yii::t('frontend', 'We support those who find themselves in a difficult life situation and empower communities to care for one another across Ukraine.') ?>
                </p>
            </div>
        </div>

        <div class="about-tabs">
            <ul class="about-tabs__nav" role="tablist">
                <li class="about-tabs__item" role="presentation">
                    <button
                        class="about-tabs__button active"
                        id="about-tab-trigger"
                        type="button"
                        role="tab"
                        data-about-tab="about"
                        data-anchor="#about-section"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-about"
                        aria-controls="tab-about"
                        aria-selected="true"
                    >
                        <?= Yii::t('frontend', 'About the mission') ?>
                    </button>
                </li>
                <li class="about-tabs__item" role="presentation">
                    <button
                        class="about-tabs__button"
                        id="team-tab-trigger"
                        type="button"
                        role="tab"
                        data-about-tab="team"
                        data-anchor="#team-section"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-team"
                        aria-controls="tab-team"
                        aria-selected="false"
                    >
                        <?= Yii::t('frontend', 'Our team') ?>
                    </button>
                </li>
                <li class="about-tabs__item" role="presentation">
                    <button
                        class="about-tabs__button"
                        id="history-tab-trigger"
                        type="button"
                        role="tab"
                        data-about-tab="history"
                        data-anchor="#story-section"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-history"
                        aria-controls="tab-history"
                        aria-selected="false"
                    >
                        <?= Yii::t('frontend', 'History') ?>
                    </button>
                </li>
            </ul>

            <div class="tab-content about-tabs__content" id="about-tabs-content">
                <div
                    class="tab-pane fade show active"
                    id="tab-about"
                    role="tabpanel"
                    aria-labelledby="about-tab-trigger"
                >
                    <section id="about-section" class="about-overview">
                        <div class="about-overview__text">
                            <p><?= Yii::t('frontend', 'Christian Mission "New Life" unites people who love God and serve people. The organization focuses on practical support for those who find themselves in complicated life circumstances.') ?></p>
                            <p><?= Yii::t('frontend', 'Since 2010 we have launched projects such as "Help to Survive", "Feed the Hungry", "Chamber of Mercy" and seasonal heating points. These initiatives create humanitarian hubs, social adaptation and rehabilitation centres, and teams that provide food and medical assistance.') ?></p>
                            <p><?= Yii::t('frontend', 'The mission started in Odesa and now operates across Ukraine with twelve branches and dozens of partner communities. Each branch unites 5 to 60 volunteers who give their time, skills and resources to serve others.') ?></p>
                            <p><?= Yii::t('frontend', '“New Life” cooperates with YMCA, International Ministry of Charity Emmanuel (IMOCE), Global Christian Support (GCS) and other partners so even more Ukrainians can receive care and hope.') ?></p>
                            <p><?= Yii::t('frontend', 'Every day people come to us for help — homeless people, families in crisis and all who suddenly became hostages of circumstances. Our purpose is not only to meet urgent needs but also to help them start a new life.') ?></p>
                        </div>
                        <div class="about-overview__stats">
                            <?php foreach ($impactStats as $stat): ?>
                                <div class="about-overview__stat">
                                    <span class="about-overview__stat-value"><?= Html::encode($stat['value']) ?></span>
                                    <span class="about-overview__stat-label"><?= Html::encode($stat['label']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <div class="about-awards" id="awards-section">
                        <div class="about-awards__header">
                            <h3><?= Yii::t('frontend', 'Awards and recognition') ?></h3>
                            <p><?= Yii::t('frontend', 'Certificates confirm our commitment to transparency and high standards of care.') ?></p>
                        </div>
                        <div class="about-awards__slider news-one-slider-wrap">
                            <div class="news-one-slider about-page-diploma-slider about-page-diploma-slider--js">
                                <div class="news-one-slider-item">
                                    <img src="/img/content/about-diploma-slider-1.png" alt="<?= Yii::t('frontend', 'Award 1') ?>">
                                </div>
                                <div class="news-one-slider-item">
                                    <img src="/img/content/about-diploma-slider-2.png" alt="<?= Yii::t('frontend', 'Award 2') ?>">
                                </div>
                                <div class="news-one-slider-item">
                                    <img src="/img/content/about-diploma-slider-3.png" alt="<?= Yii::t('frontend', 'Award 3') ?>">
                                </div>
                                <div class="news-one-slider-item">
                                    <img src="/img/content/about-diploma-slider-4.png" alt="<?= Yii::t('frontend', 'Award 4') ?>">
                                </div>
                                <div class="news-one-slider-item">
                                    <img src="/img/content/about-diploma-slider-5.png" alt="<?= Yii::t('frontend', 'Award 5') ?>">
                                </div>
                                <div class="news-one-slider-item">
                                    <img src="/img/content/about-diploma-slider-6.png" alt="<?= Yii::t('frontend', 'Award 6') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="tab-pane fade"
                    id="tab-team"
                    role="tabpanel"
                    aria-labelledby="team-tab-trigger"
                >
                    <section id="team-section" class="about-team">
                        <div class="about-team__grid">
                            <div class="about-team__lead">
                                <h2><?= Yii::t('frontend', 'People who make the mission real') ?></h2>
                                <p><?= Yii::t('frontend', 'Founder and senior pastor Fedor Herasymov began serving people on the streets of Odesa more than a decade ago. He listened to stories, shared the Gospel and built relationships that became the foundation of “New Life”.') ?></p>
                                <p><?= Yii::t('frontend', 'Today teams of chaplains, social workers and volunteers coordinate outreach programmes, humanitarian logistics and rehabilitation centres across all branches.') ?></p>
                                <p><?= Yii::t('frontend', 'We invest in training, mentoring and partnerships with churches, businesses and local authorities so that the support system keeps growing.') ?></p>
                                <div class="about-team__quote">
                                    <?= Yii::t('frontend', '“Helping people is not an easy path, but it saves souls. That is the greatest reward.”') ?>
                                </div>
                            </div>
                            <div class="about-team__resources">
                                <div>
                                    <h3><?= Yii::t('frontend', 'Team gallery') ?></h3>
                                    <?= $this->render('_team_photos', ['users' => $users]) ?>
                                </div>
                                <div>
                                    <h3><?= Yii::t('frontend', 'Profiles and contacts') ?></h3>
                                    <?= $this->render('_team_members', ['users' => $users]) ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div
                    class="tab-pane fade"
                    id="tab-history"
                    role="tabpanel"
                    aria-labelledby="history-tab-trigger"
                >
                    <section id="story-section" class="about-history">
                        <div class="about-history__header">
                            <h2><?= Yii::t('frontend', 'Our story') ?></h2>
                            <p><?= Yii::t('frontend', 'Milestones that shaped “New Life” and expanded the mission across Ukraine.') ?></p>
                        </div>
                        <div class="about-history__timeline">
                            <?php foreach ($timeline as $entry): ?>
                                <div class="about-history__year">
                                    <span class="about-history__badge"><?= Html::encode($entry['year']) ?></span>
                                    <ul class="about-history__list">
                                        <?php foreach ($entry['items'] as $item): ?>
                                            <li><?= Html::encode($item) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
