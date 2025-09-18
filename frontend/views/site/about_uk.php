<?php
/**
 * About (tabs) – clean version for RU/UA
 * Last changes: 28.08.2025
 */

use common\models\UserSocialNetwork;
use yii\helpers\Html;
use yii\helpers\Url;
// HtmlPurifier is not used here due to vendor incompatibility with PHP 8.2

/* === [FILE HEADER] BEGIN === */
/* @var $this \yii\web\View */
/* @var $users \common\models\User[] */
/* @var $currentLanguage */

$this->title = Yii::t('frontend', 'About us');
// ВАЖЛИВО: НЕ встановлюємо $this->params['custom_header'], щоб не зʼявлявся старий hero.

// Figma design tokens (colors, typography, containers) — keep dependency minimal to avoid reordering
$this->registerCssFile('/css/aboutnlm.tokens.css', [
    'depends' => [\yii\web\YiiAsset::class],
]);
// Team section (scoped) — unified external CSS
/* no additional team CSS linked (rolled back to previous look) */
/* === [FILE HEADER] END === */
?>

<div class="aboutnlm-page">
    <div class="aboutnlm-container">

    <!-- === [COMPONENT: Tabs] BEGIN === -->
    <div class="aboutnlm-tabs-wrap">
        <div class="aboutnlm-tabs" role="tablist" aria-label="About tabs">
            <button class="aboutnlm-tab-btn aboutnlm-active" data-tab="aboutnlm-about" role="tab" aria-selected="true">
                Про нас
            </button>
            <button class="aboutnlm-tab-btn" data-tab="aboutnlm-team" role="tab" aria-selected="false">
                Команда
            </button>
            <button class="aboutnlm-tab-btn" data-tab="aboutnlm-history" role="tab" aria-selected="false">
                Історія місії
            </button>
        </div>
    </div>
    <!-- === [COMPONENT: Tabs] END === -->

    <!-- === [SECTION: About] BEGIN === -->
    <section id="aboutnlm-about" class="aboutnlm-tab-content aboutnlm-active" role="tabpanel" aria-labelledby="Про нас">
        <h2 class="visually-hidden">Про нас</h2>

        <div class="aboutnlm-card">
            <div class="aboutnlm-content">
                <p>Із 2010 року Християнська місія «Нове Життя» реалізовує масштабні соціальні ініціативи, що змінюють життя сотням тисяч людей в Україні та за її межами. Впродовж 15 років ми успішно реалізували низку проектів, зокрема «Допоможемо вижити», «Нагодуй голодного» та «Палата милосердя».</p>
                <p>Місія створює пункти обігріву, притулки, центри соціальної адаптації, реабілітаційні заклади й служби допомоги безпритульним по всій країні. Деякі програми вже функціонують і за кордоном.</p>
                <p>Нові напрямки, такі як буріння свердловин, створення «Притулку матері та дитини» та відновлення домівок у деокупованих регіонах, активно розвиваються. Лише за останні півтора року вони принесли реальну допомогу тисячам нужденних.</p>
                <p>Щодня до місії звертаються люди, які опинилися у складних життєвих обставинах: безпритульні, постраждалі від війни, люди з залежностями, співзалежні та соціально незахищені верстви населення. Завдяки самовідданій праці волонтерів і фахівців ці люди отримують шанс на нове життя.</p>
                <p>Ми не обмежуємося одноразовою допомогою — наша мета — повна трансформація людських доль: допомогти вирватися з замкнутого кола проблем, відновити гідність і стати повноцінною особистістю.</p>
                <p>Після початку повномасштабного вторгнення кількість потребуючих значно зросла. У відповідь місія розширює діяльність, відкриваючи нові проекти для оперативної підтримки постраждалих. До команди постійно долучаються не лише волонтери, а й профільні фахівці, які швидко інтегруються в процеси й допомагають реалізовувати амбітні цілі.</p>

                <blockquote class="aboutnlm-quote"><strong>Слоган місії:</strong> «Любимо Бога — служимо людям!»</blockquote>
            </div>
        </div>

        <!-- === [COMPONENT: Diplomas slider] BEGIN === -->
        <section class="news-one-slider-wrap about-page-diploma-slider-wrap">
            <div class="news-one-slider about-page-diploma-slider about-page-diploma-slider--js">
                <div class="news-one-slider-item"><img src="/img/content/about-diploma-slider-1.png" alt="Подяка 1"></div>
                <div class="news-one-slider-item"><img src="/img/content/about-diploma-slider-2.png" alt="Подяка 2"></div>
                <div class="news-one-slider-item"><img src="/img/content/about-diploma-slider-3.png" alt="Подяка 3"></div>
                <div class="news-one-slider-item"><img src="/img/content/about-diploma-slider-4.png" alt="Подяка 4"></div>
                <div class="news-one-slider-item"><img src="/img/content/about-diploma-slider-5.png" alt="Подяка 5"></div>
                <div class="news-one-slider-item"><img src="/img/content/about-diploma-slider-6.png" alt="Подяка 6"></div>
            </div>
        </section>
        <!-- === [COMPONENT: Diplomas slider] END === -->
    </section>
    <!-- === [SECTION: About] END === -->

    <!-- === [SECTION: Team] BEGIN === -->
    <section id="aboutnlm-team" class="aboutnlm-tab-content" role="tabpanel" aria-labelledby="Команда">
        <h2 class="visually-hidden"><?= Yii::t('frontend','Our Team') ?></h2>

        <?php if (!empty($users)) : ?>
            <?php
            $mapPath = Yii::getAlias('@app/../config/team.groups.php');
            $teamMap = is_file($mapPath) ? (array)require $mapPath : [];
            $metaPath = Yii::getAlias('@app/../config/team.meta.php');
            $teamMeta = is_file($metaPath) ? (array)require $metaPath : [];
            if (!function_exists('aboutnlm_get_staff_role')) {
                function aboutnlm_get_staff_role($user, $lang, $map){
                    $slug = isset($user->slug) ? (string)$user->slug : '';
                    if ($slug && isset($map[$slug])) return $map[$slug];
                    $pos = '';
                    try { $pos = (string)($user->getPosition($lang) ?: ''); } catch (\Throwable $e) {}
                    $s = mb_strtolower($pos, 'UTF-8');
                    $isDirector = (strpos($s,'директор')!==false) || (strpos($s,'голова міс')!==false) || (strpos($s,'керівник міс')!==false) || (strpos($s,'director')!==false) || (strpos($s,'president')!==false);
                    if ($isDirector) return 'director';
                    $isBranch = (strpos($s,'філі')!==false) || (strpos($s,'branch')!==false);
                    if ($isBranch) return 'branch_head';
                    $isProject = (strpos($s,'проєкт')!==false) || (strpos($s,'проект')!==false) || (strpos($s,'project')!==false);
                    if ($isProject) return 'project_lead';
                    return 'volunteer';
                }
            }

            $groups = [
                'director' => [],
                'branch_head' => [],
                'project_lead' => [],
                'volunteer' => [],
            ];
            foreach ($users as $u) {
                $role = aboutnlm_get_staff_role($u, $currentLanguage, $teamMap);
                $groups[$role][] = $u;
            }

            // Render: директор (один) отдельно
            $director = isset($groups['director'][0]) ? $groups['director'][0] : null;
            ?>

            <?php if ($director): ?>
            <?php
                $overridePhoto = null;
                $slugDir = isset($director->slug)?(string)$director->slug:'';
                if ($slugDir && isset($teamMeta[$slugDir]['photo'])) {
                    $overridePhoto = $teamMeta[$slugDir]['photo'];
                }
                if (!$overridePhoto) {
                    $fallbackFile = Yii::getAlias('@webroot/img/team/director.png');
                    if (is_file($fallbackFile)) {
                        $overridePhoto = '/img/team/director.png';
                    }
                }
                $photo = $overridePhoto ?: Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $director->photo_path], true);
            ?>
            <section class="aboutnlm-card team-director" aria-label="Director">
                <div class="director-card">
                    <div class="director-band" aria-hidden="true"></div>
                    <div class="director-photo"><img src="<?= $photo ?>" alt=""></div>
                    <?php if ($name = $director->getFullName($currentLanguage)) : ?>
                        <h3 class="director-title"><?= Html::encode(mb_strtoupper($name, 'UTF-8')) ?></h3>
                    <?php endif; ?>
                    <div class="director-info">
                        <?php /* Убираем подпись должности по просьбе клиента */ ?>
                        <?php if ($info = $director->getInfo($currentLanguage)) : ?>
                            <div class="director-desc">
                                <?php
                                if (!function_exists('aboutnlm_sanitize_info')) {
                                    function aboutnlm_sanitize_info($html){
                                        $clean = strip_tags((string)$html, '<p><br><strong><em><u><a>');
                                        $clean = preg_replace('/\s+on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $clean);
                                        $clean = preg_replace('/href\s*=\s*"javascript:[^"]*"/i', 'href="#"', $clean);
                                        $clean = preg_replace("/href\s*=\s*'javascript:[^']*'/i", 'href="#"', $clean);
                                        $clean = preg_replace('/<a\b([^>]*)>/i', '<a$1 target="_blank" rel="nofollow noopener noreferrer">', $clean);
                                        return $clean;
                                    }
                                }
                                echo aboutnlm_sanitize_info($info);
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        if (!function_exists('aboutnlm_get_doc_number')) {
                            function aboutnlm_get_doc_number($user, $lang, $meta){
                                // 1) direct properties on user
                                foreach ([
                                    'certificate_number','document_number','id_number',
                                    'certificate','cert_number','certNo','cert_no',
                                    'posvidchennia_number','posvid_number','udostoverenie','udostoverenie_number'
                                ] as $k){
                                    if (isset($user->$k) && $user->$k) return (string)$user->$k;
                                }
                                // 2) user->userProfile common case
                                foreach (['userProfile','profile'] as $rel){
                                    if (isset($user->$rel)){
                                        $p = $user->$rel;
                                        foreach ([
                                            'certificate_number','document_number','id_number',
                                            'certificate','cert_number','certNo','cert_no',
                                            'posvidchennia_number','posvid_number','udostoverenie','udostoverenie_number'
                                        ] as $k){
                                            if (isset($p->$k) && $p->$k) return (string)$p->$k;
                                        }
                                    }
                                }
                                // 3) config meta by slug
                                $slug = isset($user->slug)?(string)$user->slug:'';
                                if ($slug && isset($meta[$slug]['cert']) && $meta[$slug]['cert']) return (string)$meta[$slug]['cert'];
                                // 4) try to parse from info
                                try {
                                    $info = method_exists($user,'getInfo') ? (string)$user->getInfo($lang) : '';
                                    if (!$info && method_exists($user,'getInfo')){ $info = (string)$user->getInfo($lang, 'full'); }
                                } catch (\Throwable $e){ $info=''; }
                                if ($info){
                                    if (preg_match('/№\s*(\d{6,})/u', $info, $m)) return $m[1];
                                    if (preg_match('/(\d{8,})/u', $info, $m)) return $m[1];
                                }
                                return '';
                            }
                        }
                        $doc = aboutnlm_get_doc_number($director, $currentLanguage, $teamMeta);
                        ?>
            <?php if ($doc): ?>
              <?php $label = 'Посвідчення №'; ?>
              <div class="director-cert">
                <?= Html::encode($label) ?> <?= Html::encode($doc) ?>
                <a class="director-cert-btn" href="<?= Url::to(['article/view-user', 'slug' => $director->slug]) ?>" target="_blank" rel="noopener noreferrer">Детальніше</a>
              </div>
            <?php endif; ?>
                        <div class="director-actions">
                            <a class="director-more-btn" href="<?= Url::to(['article/view-user', 'slug' => $director->slug]) ?>"><?= Html::encode(Yii::t('frontend','More Details') ?: 'Детальніше') ?></a>
                        </div>
                    </div>
                    <?php if ($director->userSocialNetworks) : ?>
                        <div class="director-socials">
                            <?php $___sn_d=0; foreach ($director->userSocialNetworks as $userSocialNetwork): if($___sn_d++>=3) break; $network = UserSocialNetwork::getSocialNetworkTitle($userSocialNetwork->social_network); ?>
                                <?= $this->render('_social_network_icons', ['network' => $network, 'userSocialNetwork' => $userSocialNetwork]); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif ?>
                </div>
            </section>
            <?php endif; ?>

            <?php
            $limits = ['branch_head'=>6,'project_lead'=>6,'volunteer'=>8];
            $labels = [
              // Explicit Ukrainian uppercase headings (match Figma / design requirement)
              'branch_head' => mb_strtoupper('Керівники філій', 'UTF-8'),
              'project_lead' => mb_strtoupper('Керівники проєктів', 'UTF-8'),
              'volunteer' => mb_strtoupper('Волонтери', 'UTF-8'),
            ];
            ?>

            <?php foreach (['branch_head','project_lead','volunteer'] as $key): $list = $groups[$key]; if (empty($list)) continue; ?>
            <section class="aboutnlm-card team-section" data-team-group="<?= Html::encode($key) ?>">
                <h3 class="team-title"><?= Html::encode($labels[$key]) ?></h3>
                <div class="articles__wrap">
                    <div class="articles__col articles__col--left category__wrap row" data-masonry-group="<?= Html::encode($key) ?>">
                        <div class="team-sizer"></div>
                        <div class="team-gutter-sizer"></div>
                        <?php $i=0; $limit = $limits[$key]; foreach ($list as $user): ?>
                            <?php $photoSrc = Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $user->photo_path], true); ?>
                            <div class="articles__item team-card <?= ($i>=$limit)?'team-hidden':'' ?>" <?= ($i>=$limit)?'style="display:none"':'' ?>>
                                <div class="articles__item-img team-photo">
                                    <img src="<?= $photoSrc ?>" alt="">
                                    <?= Html::a(Yii::t('frontend', 'More Details'), Url::to(['article/view-user', 'slug' => $user->slug]), ['class' => 'articles__item-link']) ?>
                                </div>

                                <div class="team-info-desktop">
                                    <?php $uDoc = aboutnlm_get_doc_number($user, $currentLanguage, $teamMeta); ?>
                                    <a class="team-info" href="<?= Url::to(['article/view-user', 'slug' => $user->slug]) ?>">
                                        <?php if ($fullName = $user->getFullName($currentLanguage)): ?><h3><?= Html::encode($fullName) ?></h3><?php endif; ?>
                                        <?php if (!empty($position = $user->getPosition($currentLanguage))) : ?><p><?= Html::encode($position) ?></p><?php endif ?>
                                        <?php if (!empty($uDoc)) : ?><p class="team-cert"><?= Html::encode('Посвідчення №') ?> <?= Html::encode($uDoc) ?></p><?php endif; ?>
                                        <?php if (!empty($shortInfo = $user->getInfo($currentLanguage))) : ?><p class="team-underline"><?= Html::encode($shortInfo) ?></p><?php endif ?>
                                    </a>
                                    <div class="team-card-actions">
                                      <a class="team-card-btn" href="<?= Url::to(['article/view-user', 'slug' => $user->slug]) ?>" target="_blank" rel="noopener noreferrer">Детальніше</a>
                                    </div>
                                    <?php if ($user->userSocialNetworks) : ?>
                                      <div class="user__socials-wrap team-socials">
                                                            <?php $___sn_j=0; foreach ($user->userSocialNetworks as $userSocialNetwork): if($___sn_j++>=5) break; $network = UserSocialNetwork::getSocialNetworkTitle($userSocialNetwork->social_network); ?>
                                                                <?= $this->render('_social_network_icons', ['network' => $network, 'userSocialNetwork' => $userSocialNetwork]); ?>
                                                            <?php endforeach; ?>
                                                        </div>
                                    <?php endif ?>
                                </div>

                                <div class="team-info-mobile">
                                    <?php if ($fullName = $user->getFullName($currentLanguage)): ?><h3><?= Html::encode($fullName) ?></h3><?php endif; ?>
                                    <?php if (!empty($position = $user->getPosition($currentLanguage))) : ?><p><?= Html::encode($position) ?></p><?php endif ?>
                                    <?php if ($user->userSocialNetworks) : ?>
                                        <div class="social-icons">
                                            <?php $___sn_j=0; foreach ($user->userSocialNetworks as $userSocialNetwork): if($___sn_j++>=5) break;
                                                $network = UserSocialNetwork::getSocialNetworkTitle($userSocialNetwork->social_network); ?>
                                                <?= $this->render('_social_network_icons', ['network' => $network, 'userSocialNetwork' => $userSocialNetwork]); ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endforeach; ?>

            <?php if (($groups['branch_head']||$groups['project_lead']||$groups['volunteer'])): ?>
            <div class="aboutnlm-card team-more-wrap">
                <button type="button" class="team-more-btn team-more-btn--js"><?= Html::encode(Yii::t('frontend','Show more') ?: 'Показати більше') ?></button>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="aboutnlm-card">
                <p>В організації понад 8 філій, у кожній працює від 5 до 60 волонтерів.</p>
            </div>
        <?php endif; ?>
    </section>
    <!-- === [SECTION: Team] END === -->

    <!-- === [SECTION: History timeline] BEGIN === -->
    <section id="aboutnlm-history" class="aboutnlm-tab-content" role="tabpanel" aria-labelledby="Історія місії">
        <h2 class="visually-hidden">Історія місії</h2>

        <div class="aboutnlm-card">
            <div class="timeline" aria-label="Mission timeline">

                <!-- === [DATA: Timeline UA] BEGIN === -->
                <?php
                $timeline = [
                    2010 => [
                        'Початок служіння Федора Герасимова безпритульним в Одесі.',
                        'Служіння в місцях позбавлення волі як капеланів.',
                    ],
                    2011 => [
                        'Відкриття проекту «Розділи хліб з голодним» — щоденне годування безпритульних.',
                        'Відкриття церкви «Християнський центр Пробудження».',
                    ],
                    2012 => [
                        'Співпраця зі ЗМІ та владою Одеси.',
                        'Відкриття пунктів обігріву в Одесі.',
                        'Запуск філії місії та проектів по Україні.',
                    ],
                    2014 => [
                        'Запуск «Допоможемо вижити» — пункти збору та видачі гуманітарної допомоги.',
                    ],
                    2017 => [
                        'Розширення «Розділи хліб з голодним» та «Допоможемо вижити» у 12 містах України.',
                    ],
                    2018 => [
                        'Відкриття реабілітаційного центру «Нове Життя» у Запоріжжі.',
                    ],
                    2019 => [
                        'Початок роботи в Індії.',
                        'Придбання будівлі для центру соціальної адаптації в Одеській області.',
                        'Перемога в номінації «Благодійна Одеса».',
                    ],
                    2020 => [
                        'Будівництво ангару для гуманітарної допомоги в Одесі.',
                        'Початок будівництва Будинку Матері та Дитини.',
                        'Будівництво притулку для безпритульних у Запоріжжі.',
                    ],
                    2021 => [
                        'Відкриття пункту обігріву в Києві.',
                        'Філія місії в Харкові.',
                        'Відправлення контейнера з гуманітарною допомогою на Кубу.',
                        'Купівля будівлі для церкви та притулку для людей похилого віку.',
                        'Початок реконструкції церкви в Одесі.',
                    ],
                    2022 => [
                        'Початок війни. Допомога по всій Україні (87 представництв).',
                        'Евакуація постраждалих до Молдови, Польщі та Румунії.',
                        'Буріння свердловин у Миколаєві, Херсоні та Дніпропетровській області.',
                        'Масштабування видачі гуманітарної допомоги продуктами.',
                        'Будівництво модульного містечка для біженців.',
                    ],
                    2023 => [
                        'Відновлення будинків після підриву Каховської ГЕС.',
                        'Буріння свердловин у Херсоні та Дніпропетровській області.',
                    ],
                    2024 => [
                        'Планування будівництва церкви в смт Великий Дальник.',
                        'Перемога в номінації «Благодійна Україна».',
                        '7 дитячих свят (3000+ дітей) та 3 табори (2000 дітей).',
                    ],
                    2025 => [
                        'Початок планування будівництва притулку для людей похилого віку та інвалідів.',
                    ],
                ];
                /* === [DATA: Timeline UA] END === */

                /* === [COMPONENT: Timeline renderer] BEGIN === */
                $i = 0;
                foreach ($timeline as $year => $items):
                    $side = ($i % 2 === 0) ? 'left' : 'right';
                    $i++;
                ?>
                    <article class="tl-item <?= $side ?>">
                        <div class="tl-dot" aria-hidden="true"></div>
                        <!-- УВАГА: .tl-arm прибрано за вимогою дизайну -->
                        <div class="tl-card">
                            <div class="tl-year"><?= Html::encode($year) ?></div>
                            <ul class="tl-list">
                                <?php foreach ($items as $txt): ?>
                                    <li><?= Html::encode($txt) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </article>
                <?php endforeach; ?>
                <!-- === [COMPONENT: Timeline renderer] END === -->

            </div>
        </div>
    </section>
    <!-- === [SECTION: History timeline] END === -->
    </div>
</div>

<style>
/* === [STYLE: Base layout & container] BEGIN === */
.aboutnlm-page {
  /* Map tokens with safe fallbacks to avoid transparency if tokens file fails */
  --nl-dark: var(--nlm-accent, #173750);
  --nl-bg: var(--nlm-bg, #F5F7FA);
  --nl-white: var(--nlm-surface, #FFFFFF);
  --nl-shadow: var(--nlm-shadow-lg, 0 12px 32px rgba(44,62,80,.10));

  /* Global container system (orientation-independent) */
  --pad-x: clamp(12px, 4vw, 28px);  /* side paddings */
  --container-max: 1140px;          /* recommended desktop max */
  --gap-section: clamp(24px, 6vw, 56px);
  --card-pad: clamp(16px, 3vw, 24px);

  /* Tabs (Desktop 1920 baseline) */
  --tabs-h: 80px;
  --tabs-px: 48px;
  --tabs-minw: 320px;
  --tabs-gap: 40px;
  --tabs-radius: 24px;
  --tabs-fs: 24px;
  /* Tabs sizing */
  --tab-h: 46px;        /* default desktop/tablet height */
  --tab-pad-y: 10px;    /* vertical padding for white shell */
  /* Equal tab width by breakpoint (fixed values) */
  --tab-equal-w: 260px; /* ≥1140px (и ≥1400px) */

  background: var(--nl-bg);
  padding-top: 12px; padding-bottom: 32px;
  box-sizing: border-box;
}
.aboutnlm-page *{ box-sizing: border-box; }

/* Global container: centers all sections uniformly */
.aboutnlm-container{
  max-width: var(--container-max);
  margin: 0 auto;
  padding-left: var(--pad-x); padding-right: var(--pad-x);
}
.visually-hidden{position:absolute!important;clip:rect(0 0 0 0)!important;clip-path:inset(50%)!important;height:1px!important;width:1px!important;overflow:hidden!important;white-space:nowrap!important;border:0!important;padding:0!important;margin:-1px!important;}

.aboutnlm-card{
    background:var(--nlm-surface, #FFFFFF); border-radius:var(--nlm-radius-lg, 14px); box-shadow:var(--nl-shadow);
    padding:var(--card-pad); margin: var(--gap-section) auto; max-width:100%;
}
/* === [STYLE: Base layout & container] END === */

/* === [STYLE: Tabs base] BEGIN === */
.aboutnlm-tabs-wrap{
    /* Всередині контейнера; завжди видима біла «оболонка» */
    width:100%; margin: clamp(24px, 4vw, 32px) auto;
    padding: 0 var(--pad-x); /* горизонтальний паддінг від контейнера */
    background:#FFFFFF; border-radius:16px; box-shadow:0 4px 14px rgba(23,55,80,.08);
    display:flex; align-items:center; min-height: calc(var(--tab-h) + 2*var(--tab-pad-y));
}
.aboutnlm-tabs{
    /* Всегда в один ряд; при нехватке места — горизонтальный скролл */
    display:flex; flex-wrap:nowrap; gap: clamp(12px, 2.2vw, 16px);
    justify-content:center; align-items:center; width:100%; margin:0 auto; padding:0;
    overflow-x:auto; overflow-y:hidden; -webkit-overflow-scrolling:touch; scrollbar-width:none;
    white-space:nowrap;
}
.aboutnlm-tabs::-webkit-scrollbar{display:none;}
.aboutnlm-tab-btn{
    height: var(--tab-h); padding:0 clamp(18px, 2.2vw, 24px); border:none; border-radius:14px;
    background:#F5F7FA; color:#173750; white-space:nowrap;
    font-family:'Inter', system-ui, Arial; font-weight:500; font-size:18px; line-height:1; text-transform:uppercase;
    display:flex; align-items:center; justify-content:center; box-shadow: inset 0 0 0 1px rgba(23,55,80,.06);
    transition:transform .18s ease, box-shadow .18s ease, background-color .18s ease, color .18s ease; cursor:pointer;
    width: var(--tab-equal-w, auto); flex: 0 0 var(--tab-equal-w, auto);
}
.aboutnlm-tab-btn.aboutnlm-active{
    background:#173750; color:#F5F7FA; box-shadow:0 10px 24px rgba(23,55,80,.22);
}
/* === [STYLE: Tabs base] END === */

/* === [STYLE: Tab panels] BEGIN === */
.aboutnlm-tab-content{ display:none; }
.aboutnlm-tab-content.aboutnlm-active{ display:block; }
/* === [STYLE: Tab panels] END === */

/* === [STYLE: About content] BEGIN === */
.aboutnlm-content{ max-width: var(--nlm-container-xl); margin: 0 auto; }
.aboutnlm-content p{ margin:0 0 14px; font-size:18px; line-height:1.65; color:var(--nlm-text, #1f2d3a); }
.aboutnlm-content p:first-of-type{ font-size:20px; line-height:1.7; }
.aboutnlm-quote{ margin:18px 0 4px; padding:14px 16px; background:#f6f9ff; border-left:4px solid var(--nl-dark); border-radius:8px; }
/* === [STYLE: About content] END === */

/* === [STYLE: Timeline base aligned to container grid] BEGIN === */
/* Desktop/tablet: centered line and alternating sides */
.timeline{
  position:relative; z-index:0; margin: var(--gap-section) auto; padding:10px 0 24px; max-width:100%;
}
.timeline:before{
  content:""; position:absolute; left:50%; top:0; bottom:0; width:2px; transform:translateX(-50%);
  background:rgba(12,36,56,.25);
}
.tl-item{ position:relative; margin:clamp(12px, 2.4vw, 24px) 0; display:grid; grid-template-columns:1fr 1fr; align-items:center; }
.tl-card{
  grid-column: 1; justify-self:end; width: calc(80% - 18px);
  background:#fff; border-radius:18px; box-shadow:0 6px 20px rgba(0,0,0,.06);
  padding: clamp(12px, 2vw, 18px);
  margin-right:16px;
}
.tl-item.left .tl-card{ grid-column: 1; }
.tl-item.right .tl-card{ grid-column: 2; justify-self:start; margin-left:16px; margin-right:0; }
.tl-year{ font:600 18px/1 var(--nlm-font-sans); color:var(--nl-dark); margin-bottom:10px; }
.tl-list{ margin:0; padding-left:18px; }
.tl-list li{ margin:4px 0; font-size:16px; line-height:1.45; }
.tl-dot{ position:absolute; left:50%; top:50%; transform:translate(-50%, -50%); width:14px; height:14px; border-radius:50%; background:#0b2f49; box-shadow:0 0 0 6px rgba(11,47,73,.1); }
.tl-arm{ display:none !important; }
/* Tablet sizing tweaks */
@media (max-width: 1140px){
  .tl-card{ width: calc(80% - 16px); margin-right:14px; }
  .tl-item.right .tl-card{ margin-left:14px; }
}
/* Mobile: one column with left line */
@media (max-width: 767.98px){
  /* Мобільна сітка таймлайна: 2 колонки — ліва (лінія+зазор), права (картка) */
  .timeline{
    --spine-x: 16px;        /* позиція вертикальної лінії від лівого краю таймлайна */
    --tl-line-gap: 40px;    /* відступ від лінії до картки */
    padding-left: 0; padding-right: 0; overflow-x: hidden;
  }
  .timeline:before{ left: var(--spine-x); transform:none; width:2px; border:none; background:rgba(12,36,56,.25); }
  .tl-item{
    /* перераховуємо колонки: перша = лінія+відступ, друга = контент */
    grid-template-columns: calc(var(--spine-x) + var(--tl-line-gap)) 1fr;
    column-gap: 0; margin-left: 0; margin-right: 0; align-items: start;
  }
  .tl-dot{ left: var(--spine-x); transform: translate(-50%, -50%); }
  /* Картка завжди у правій колонці, без спадкованих відступів ПК */
  .tl-item.left .tl-card,
  .tl-item.right .tl-card{ grid-column: 2; justify-self: stretch; margin: 0 !important; }
  .tl-card{ box-sizing: border-box; padding:16px; max-width: 100%; width: auto; }
}
/* === [STYLE: Timeline base aligned to container grid] END === */

/* Legacy alternating spacing disabled to keep strict grid alignment */

/* === [STYLE: General breakpoints] BEGIN === */
@media (max-width:900px){
  /* сохраняем компактные внешние отступы, не сбиваем вертикальные паддинги оболочки */
  .aboutnlm-tabs-wrap{ margin:20px auto 10px; }
  .aboutnlm-card{ padding:18px; }
  /* Таймлайн на мобильных управляется блоком ≤767.98px (ниже) */
}
@media (max-width:600px){
  .aboutnlm-page{ padding:0 15px; }
  .aboutnlm-card{ margin:16px auto; padding:18px; }
  .tl-list li{ margin:10px 0; }
}
/* === [STYLE: General breakpoints] END === */

/* === [STYLE: Responsive container scaling] BEGIN === */
/* ≥ 1440px already covered by defaults above */

/* ≥1140px and <1440px (Recommended desktop) */
@media (max-width: 1400px){
  .aboutnlm-page{ --nlm-container-xxl: var(--nlm-container-xl); }
  .aboutnlm-page{ --outer-x: 32px; --section-gap: 70px; --card-pad: 36px; }
  .aboutnlm-tabs{ justify-content:center; }
}
/* ≥992px and <1200px (Tablet landscape / 960 container) */
@media (max-width: 1200px){
  .aboutnlm-page{ --nlm-container-xxl: var(--nlm-container-lg); }
  .aboutnlm-page{ --outer-x: 28px; --section-gap: 60px; --card-pad: 28px; }
  .aboutnlm-tabs-wrap{ margin:28px auto 22px; }
  .aboutnlm-tabs{ gap: 18px; }
  .aboutnlm-tab-btn{ height:46px; border-radius:14px; font-size:17px; padding:0 clamp(14px, 2vw, 18px); }
  .aboutnlm-page{ --tab-equal-w: 240px; }
}
/* ≥768px and <992px (Tablet portrait / 720 container) */
@media (max-width: 992px){
  .aboutnlm-page{ --nlm-container-xxl: var(--nlm-container-md); }
  .aboutnlm-page{ --outer-x: 24px; --section-gap: 40px; --card-pad: 24px; }
  .aboutnlm-tabs{ gap:16px; justify-content:center; }
  .aboutnlm-tab-btn{ height:46px; font-size:16px; padding:0 14px; }
  .aboutnlm-page{ --tab-equal-w: 220px; }
}
/* <768px (Mobile portrait / 540 container and down) */
@media (max-width: 768px){
  .aboutnlm-page{ --nlm-container-xxl: var(--nlm-container-sm); }
  .aboutnlm-page{ --outer-x: 20px; --section-gap: 36px; --card-pad: 20px; }
  .aboutnlm-page{ --tab-h: 44px; --tab-pad-y: 12px; }
  .aboutnlm-tabs{ justify-content:flex-start; gap:12px; }
  .aboutnlm-tab-btn{ height:44px; font-size:15px; padding:0 12px; }
  .aboutnlm-page{ --tab-equal-w: 200px; }
  /* Увеличиваем белую подкладку по высоте только на мобайле */
  .aboutnlm-tabs-wrap{ padding-top: var(--tab-pad-y); padding-bottom: var(--tab-pad-y); }
  
  /* МОБИЛЬНЫЕ ИСПРАВЛЕНИЯ: уменьшаем отступы блоков от края в 2 раза */
  .aboutnlm-page{ 
    --pad-x: 6px; /* было 12px, стало 6px */
    padding-left: 6px !important; 
    padding-right: 6px !important; 
  }
  .aboutnlm-container{ 
    padding-left: 6px !important; 
    padding-right: 6px !important; 
  }
  
  /* Исправляем позиционирование текста директора на мобильных */
  .team-director .director-title{ 
    top: 0 !important; 
    margin: 12px 0 16px !important; 
    text-align: center !important; 
    padding-left: 0 !important; 
  }
  .team-director .director-info{ 
    margin-top: 0 !important; 
    padding: 16px !important; 
    height: auto !important; 
    background: #173750 !important;
    border-radius: 8px !important;
  }
  
  /* Убираем большие синие козырьки над фото */
  .team-director .director-band {
    display: none !important;
  }
  
  /* Возвращаем исходный размер фото директора */
  .team-director .director-photo {
    height: 360px !important;
  }
  
  /* Убираем лишнее пространство сверху блоков команды */
  .team-section{ 
    margin-top: 16px !important; 
  }
  .team-title{ 
    margin-bottom: 8px !important; 
    padding-left: 6px !important; 
  }
  
  /* Делаем карточки команды компактными и размещаем по 2 в ряд */
  .team-section .articles__col{ 
    grid-template-columns: repeat(2, 1fr) !important; 
    gap: 12px !important; 
    padding: 6px !important; 
  }
  .team-card{ 
    min-height: auto !important; 
  }
  .team-card .team-photo{ 
    height: 280px !important; /* Возвращаем нормальный размер фото */
    padding: 12px 8px 0 !important; 
  }
  
  /* Убираем лишние синие полосы у карточек команды */
  .team-card::before {
    display: none !important;
  }
  .team-card .team-info{ 
    padding: 12px !important; 
    gap: 6px !important; 
  }
  .team-card .team-info h3{ 
    font-size: 16px !important; 
    line-height: 20px !important; 
  }
  .team-card .team-info p{ 
    font-size: 13px !important; 
    line-height: 16px !important; 
  }
  .team-card .team-info .team-cert{ 
    font-size: 14px !important; 
    line-height: 18px !important; 
  }
  .team-card .team-info .team-underline{ 
    font-size: 16px !important; 
    line-height: 20px !important; 
  }
  .team-card-actions{ 
    padding-bottom: 8px !important; 
  }
  .team-card-btn{ 
    padding: 6px 10px !important; 
    font-size: 13px !important; 
  }
  .team-card .team-socials{ 
    padding-bottom: 12px !important; 
    gap: 8px !important; 
  }
  .team-card .team-socials a{ 
    width: 32px !important; 
    height: 32px !important; 
  }
  .team-card .team-socials svg{ 
    width: 16px !important; 
    height: 16px !important; 
  }
}

/* <576px (Small mobile width adjustments) */
@media (max-width: 576px){
  .aboutnlm-page{ --outer-x: 16px; --section-gap: 32px; --card-pad: 16px; }
  
  /* Дополнительно уменьшаем отступы для очень маленьких экранов */
  .aboutnlm-page{ 
    --pad-x: 4px; /* было 8px, стало 4px */
    padding-left: 4px !important; 
    padding-right: 4px !important; 
  }
  .aboutnlm-container{ 
    padding-left: 4px !important; 
    padding-right: 4px !important; 
  }
  
  .team-section .articles__col{ 
    gap: 8px !important; 
    padding: 4px !important; 
  }
  .team-card .team-photo{ 
    height: 240px !important; /* Возвращаем нормальный размер */
  }
}
/* <400px (Very small mobile) */
@media (max-width: 400px){
  .aboutnlm-page{ --outer-x: 12px; --section-gap: 28px; --card-pad: 14px; }
  
  /* Минимальные отступы для очень маленьких экранов */
  .aboutnlm-page{ 
    --pad-x: 3px; /* было 6px, стало 3px */
    padding-left: 3px !important; 
    padding-right: 3px !important; 
  }
  .aboutnlm-container{ 
    padding-left: 3px !important; 
    padding-right: 3px !important; 
  }
  
  .team-section .articles__col{ 
    gap: 6px !important; 
    padding: 3px !important; 
  }
  .team-card .team-photo{ 
    height: 220px !important; /* Возвращаем нормальный размер */
  }
}
/* === [STYLE: Responsive container scaling] END === */

/* === [STYLE: Mobile-specific fixes] BEGIN === */
/* Дополнительные исправления для мобильной верстки */
@media (max-width: 768px) {
  /* Исправляем карточку директора на мобильных */
  .team-director .director-card {
    grid-template-columns: 1fr !important;
    grid-template-rows: auto auto auto !important;
    padding: 16px !important;
    gap: 16px !important;
  }
  
  .team-director .director-photo {
    grid-column: 1 !important;
    grid-row: 2 !important;
    height: 280px !important;
  }
  
  .team-director .director-info {
    grid-column: 1 !important;
    grid-row: 3 !important;
    background: #173750 !important;
    border-radius: 8px !important;
    margin: 0 !important;
    padding: 16px !important;
    height: auto !important;
  }
  
  .team-director .director-band {
    display: none !important;
  }
  
  /* Убираем лишние отступы у заголовков секций */
  .team-section {
    margin-top: 16px !important;
  }
  
  .team-section:first-of-type {
    margin-top: 16px !important;
  }
  
  /* Делаем карточки команды более компактными */
  .team-card {
    border-radius: 6px !important;
  }
  
  .team-card .team-photo img {
    border-radius: 4px !important;
  }
  
  /* Уменьшаем размеры кнопок и социальных иконок */
  .team-card-btn {
    font-size: 12px !important;
    padding: 5px 8px !important;
  }
  
  .team-card .team-socials a {
    width: 28px !important;
    height: 28px !important;
  }
  
  .team-card .team-socials svg {
    width: 14px !important;
    height: 14px !important;
  }
}

/* Дополнительные исправления для очень маленьких экранов */
@media (max-width: 480px) {
  .team-section .articles__col {
    grid-template-columns: 1fr !important;
    gap: 16px !important;
    padding: 8px !important;
  }
  
  .team-card .team-photo {
    height: 260px !important; /* Возвращаем нормальный размер */
  }
  
  .team-title {
    padding-left: 8px !important;
    font-size: 18px !important;
  }
  
  /* Дополнительно уменьшаем отступы для очень маленьких экранов */
  .aboutnlm-page{ 
    --pad-x: 4px; /* было 8px, стало 4px */
    padding-left: 4px !important; 
    padding-right: 4px !important; 
  }
  .aboutnlm-container{ 
    padding-left: 4px !important; 
    padding-right: 4px !important; 
  }
}

/* === [STYLE: Mobile-specific fixes] END === */

/* === [STYLE: Diplomas slider] BEGIN === */
.about-page-diploma-slider-wrap{
  margin: calc(var(--section-gap) * 0.4) auto 0; padding:var(--card-pad); max-width: var(--nlm-container-xxl);
  /* ensure a solid white card background like other sections */
  background: var(--nlm-surface, #FFFFFF); border-radius: var(--nlm-radius-lg); box-shadow: var(--nl-shadow);
}
.about-page-diploma-slider{ margin: 0 auto; }
.about-page-diploma-slider .news-one-slider-item{
  padding:10px;
  /* white card behind each slide to match other aboutnlm-card blocks */
  background: #FFFFFF; border-radius: 12px; box-shadow: 0 10px 28px rgba(23,55,80,.10); box-sizing:border-box; padding:12px;
}
.about-page-diploma-slider .news-one-slider-item img{
  display:block; width:100%; max-height:360px; object-fit:contain;
  background:transparent; border-radius:8px; box-shadow:none; padding:0; display:block;
}
@media (max-width:900px){
  .about-page-diploma-slider-wrap{ padding:12px; }
}
@media (max-width:600px){
  .about-page-diploma-slider-wrap{ padding:10px; border-radius: 12px; }
}
/* === [STYLE: Diplomas slider] END === */

/* === [STYLE: Media defaults] BEGIN === */
.aboutnlm-page img{ max-width:100%; height:auto; object-fit: contain; }
/* Orientation-specific rules removed: we rely solely on viewport width */
/* === [STYLE: Media defaults] END === */

/* === [PATCH: Tabs white outline] BEGIN === */
.aboutnlm-tab-btn{ box-shadow:inset 0 0 0 1px rgba(23,55,80,.06), 0 0 0 2px var(--nlm-surface); }
.aboutnlm-tab-btn.aboutnlm-active{ box-shadow:0 6px 18px rgba(23,55,80,.25), 0 0 0 2px var(--nlm-surface); }
/* === [PATCH: Tabs white outline] END === */

/* old ad-hoc mobile timeline patches removed (все покрито новими правилами вище) */
</style>

<script>
/* === [SCRIPT: Tabs activation] BEGIN === */
(function(){
  var tabs = document.querySelectorAll('.aboutnlm-tab-btn');
  var panels = document.querySelectorAll('.aboutnlm-tab-content');
  var tabsRoot = document.querySelector('.aboutnlm-tabs');

  function activate(btn){
    tabs.forEach(function(b){
      b.classList.remove('aboutnlm-active');
      b.setAttribute('aria-selected','false');
    });
    panels.forEach(function(p){ p.classList.remove('aboutnlm-active'); });

    btn.classList.add('aboutnlm-active');
    btn.setAttribute('aria-selected','true');
    var target = document.getElementById(btn.getAttribute('data-tab'));
    if (target) target.classList.add('aboutnlm-active');

    try{ btn.scrollIntoView({inline:'center', behavior:'smooth', block:'nearest'}); }catch(e){}
  }

  tabs.forEach(function(btn){
    btn.addEventListener('click', function(){ activate(btn); });
  });

  // Equal widths заданы фиксированными значениями в CSS переменной --tab-equal-w по брейкпоинтам.
  // Скриптовое выравнивание отключено по требованию.
})();
/* === [SCRIPT: Tabs activation] END === */
</script>

<style>
/* Ensure team grid isn't overridden by Masonry or legacy styles */
#aboutnlm-team .articles__col { height: auto !important; }
#aboutnlm-team .articles__col .articles__item { position: static !important; width: auto !important; top: auto !important; left: auto !important; transform: none !important; }
/* Kill legacy “read more” button styles inside cards to avoid white squares */
#aboutnlm-team .articles__item .articles__item-link{
  display:none !important;
  width:0 !important; height:0 !important; padding:0 !important; margin:0 !important; border:0 !important; box-shadow:none !important;
}
/* Reset any default paddings/backgrounds that create gaps in cards */
#aboutnlm-team .articles__item{ padding:0 !important; background: transparent !important; }
</style>

<script>
// Remove Masonry layout on team columns (some global scripts initialize Masonry)
(function(){
  function restoreTeamGrid(){
    var cols = document.querySelectorAll('#aboutnlm-team .articles__col');
    cols.forEach(function(col){
      try{
        if (window.jQuery && typeof $(col).masonry === 'function' && $(col).data('masonry')){
          $(col).masonry('destroy');
        }
      }catch(e){}
      col.style.height = '';
      col.querySelectorAll('.articles__item').forEach(function(it){
        it.style.position = '';
        it.style.top = '';
        it.style.left = '';
        it.style.width = '';
        it.style.transform = '';
      });
    });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', restoreTeamGrid); else restoreTeamGrid();
  // run again shortly after load to catch late initialisers
  setTimeout(restoreTeamGrid, 300);
})();
</script>

<script>
// Team-only behavior: relayout on tab open and reveal hidden items (parity with UA page)
(function(){
  var moreBtn = document.querySelector('.team-more-btn--js');
  function relayoutMasonry(){
    try{
      if (window.jQuery) {
        var $ = window.jQuery;
        $('.category__wrap').each(function(){
          var $w = $(this);
          if (typeof $w.masonry === 'function') {
            if ($w.is('[data-masonry-group]')){
              // Team groups: CSS Grid only, Masonry not used
              return;
            } else {
              // default for other grids
              if (!$w.data('masonry')) {
                $w.masonry({itemSelector: '.articles__item', columnWidth: '.articles__item', percentPosition:true, gutter:0});
              }
            }
            $w.masonry('layout');
          }
        });
      }
    }catch(e){}
  }
  // On clicking tabs, if team is shown, relayout
  document.querySelectorAll('.aboutnlm-tab-btn').forEach(function(b){
    b.addEventListener('click', function(){
      var id = b.getAttribute('data-tab');
      if (id === 'aboutnlm-team') setTimeout(relayoutMasonry, 10);
    });
  });
  if (moreBtn){
    moreBtn.addEventListener('click', function(){
      document.querySelectorAll('#aboutnlm-team .articles__item.team-hidden').forEach(function(it){ it.style.display='block'; it.classList.remove('team-hidden'); });
      relayoutMasonry();
      moreBtn.parentElement.removeChild(moreBtn);
    });
  }
  // If team tab already active on load
  if (document.getElementById('aboutnlm-team') && document.getElementById('aboutnlm-team').classList.contains('aboutnlm-active')) setTimeout(relayoutMasonry, 50);
})();
</script>

<style>
/* Team-only minimal styles */
.team-title{ margin:0 0 12px 0; font:600 20px/1.2 var(--nlm-font-sans, system-ui, Arial); color:var(--nl-dark, #173750); padding-left:30px; box-sizing:border-box; }
.team-more-wrap{ text-align:center; }
.team-more-btn{ appearance:none; border:1px solid #173750; background:#fff; color:#173750; border-radius:5px; padding:6px 14px; font-weight:400; height:56px; min-width:287px; cursor:pointer; font-family: var(--nlm-font-sans, system-ui, Arial); font-size:18px; line-height:22px; }
.team-more-btn:hover{ box-shadow:0 4px 12px rgba(23,55,80,.12); }

/* Director card (Frame 37): independent layout */
.team-director .director-card{
  position:relative; /* card as positioning context */
  /* Figma-derived local sizing tokens (use concrete desktop defaults with fluid fallbacks) */
  --dc-pad: 20px; /* aboutnlm-card inner padding in Figma */
  --photo-h: 450px; /* increased ~25% from 360px as requested */
  --band-h: clamp(240px, 24vh, 316px); /* doubled height: min ~240px, max ~316px */
  --title-h: 88px; /* reserved vertical space for the uppercase title row; increased so band positions below the title + margin */
  padding: var(--dc-pad); box-sizing:border-box; display:grid; overflow:hidden; border-radius:14px;
  /* Keep photo container at ~32% and text at ~52% but allow graceful shrinking via minmax() */
  grid-template-columns: minmax(220px, 32%) minmax(300px, 52%);
  grid-template-rows: auto var(--photo-h) auto; /* title row, photo row (with band), socials/footer */
  column-gap: 28px; row-gap: 0; align-items:start;
}
/* Full-width blue band that sits behind the photo/text area */
.team-director .director-band{
  /* span the white card content area exactly (edge-to-edge inside the card padding) */
  position: absolute;
  left: calc(-1 * var(--dc-pad));
  right: calc(-1 * var(--dc-pad));
  /* compute top so the band is vertically centered relative to the photo row */
  top: calc(var(--dc-pad) + var(--title-h) + ((var(--photo-h) - var(--band-h)) / 2));
  height: var(--band-h);
  background: #173750; /* Figma primary dark-blue */
  z-index: 1; pointer-events: none; /* band sits behind photo/info; card overflow hides external corners */
}
.team-director .director-photo{ grid-column:1; grid-row:2; position:relative; z-index:3; height: var(--photo-h); }
.team-director .director-photo img{ width:100%; height:100%; object-fit:cover; border-radius:12px; display:block; box-shadow:0 10px 28px rgba(23,55,80,.15); }
.team-director .director-title{ position:relative; z-index:5; grid-column:2; grid-row:1; margin:0 0 22px; top:123px; color:var(--nl-dark,#173750); font-weight:600; font-size:clamp(20px, 2.1vw, 32px); line-height:1.15; font-family: var(--nlm-font-sans, system-ui, Arial); letter-spacing:.2px; text-transform:uppercase; text-align:left; padding-left:18px; }
.team-director .director-info{
  /* place info inside the photo row so it sits within the blue band vertically */
  position:relative; z-index:4; grid-column:2; grid-row:2; align-self:start;
  width:100%; display:flex; flex-direction:column; justify-content:center; gap:12px;
  color:#fff; background:transparent; border-radius:6px; padding:0 18px;
  box-sizing:border-box; overflow-wrap:anywhere;
  /* Size and offset the info block so its vertical center matches the blue band */
  height: var(--band-h);
  /* nudge the block slightly down so text centers visually (desktop) */
  margin-top: calc((var(--photo-h) - var(--band-h)) / 2 + 18px);
}
.team-director .director-position{ margin:0; font-weight:500; font-size:clamp(14px, 1.1vw, 18px); line-height:1.3; font-family:var(--nlm-font-sans, system-ui, Arial); color:#fff; }
.team-director .director-desc{ margin:0; font-weight:400; font-size:clamp(15px, 1.1vw, 18px); line-height:clamp(20px, 1.9vw, 26px); font-family:var(--nlm-font-sans, system-ui, Arial); color:#fff; }
.team-director .director-desc p{ margin:0 0 6px; }
.team-director .director-cert{ margin:4px 0 0; font-weight:700; font-size:16px; line-height:1.2; font-family:var(--nlm-font-sans, system-ui, Arial); color:#FFEA3B; display:flex; gap:12px; align-items:center; }
.team-director .director-cert-btn{ display:inline-block; background:transparent; color:#fff; border:1px solid rgba(255,255,255,.16); padding:8px 12px; border-radius:6px; font-weight:700; font-size:14px; text-decoration:none; }
.team-director .director-cert-btn:hover{ background:rgba(255,255,255,.04); }
.team-director .director-actions{ margin-top:2px; }
.team-director .director-more-btn{ display:inline-block; color:var(--nl-dark,#173750); background:transparent; text-decoration:underline; font-weight:700; font-size:clamp(14px, 1.1vw, 18px); line-height:1.2; padding:2px 0; }
.team-director .director-more-btn:hover{ text-decoration:none; }

/* hide duplicate 'More Details' link for director — we surface profile link next to certificate instead */
.team-director .director-more-btn{ display:none !important; }
.team-director .director-socials{ position:relative; z-index:1; grid-column:2; grid-row:3; width:100%; display:flex; gap:14px; align-items:center; justify-content:flex-start; margin-top:12px; }
.team-director .director-socials a{ display:inline-flex; width:56px; height:56px; align-items:center; justify-content:center; border-radius:50%; background:#173750; box-shadow:0 6px 14px rgba(23,55,80,.18); }
.team-director .director-socials svg{ width:24px; height:24px; }

/* Director stays as two columns on desktop; single column only on tablet/mobile */
@media (max-width: 991px){
  .team-director .director-card{ grid-template-columns: 1fr; padding:16px; }
  .team-director .director-title{ grid-column:1; margin:12px 0 6px; text-align:center; }
  .team-director .director-info{ grid-column:1; /* restore normal flow on small screens */ height:auto; margin-top:0; padding:14px 16px; align-self:stretch; justify-content:flex-start; }
  .team-director .director-socials{ position:static; width:auto; gap:12px; margin-top:10px; justify-content:center; }
  .team-director .director-band{ display:none; }
}

/* Team cards (non-director) – Frame 1000005301 */

.team-section .articles__wrap{ display:block; }
.team-section .articles__col{
  display:grid;
  grid-template-columns: repeat(3, 1fr);
  gap:32px;
  padding:30px;
  box-sizing:border-box;
  width:100%;
  /* make rows equal height so all cards align */
  grid-auto-rows: 1fr;
  align-items: stretch; /* ensure items fill the row */
}
.team-card{
  position:relative; box-sizing:border-box; width:100%; min-height:0;
  /* Use site palette dark-blue for better contrast with card text */
  background: var(--nl-dark, #173750); border:1px solid rgba(0,0,0,0.06); box-shadow:0 6px 18px rgba(11,47,73,.12);
  border-radius:8px; overflow:hidden; margin:0;
  display:flex; flex-direction:column; align-items:stretch;
  /* fill grid cell so all cards in a row have equal height */
  height: 100%;
  /* per-card band gap (space left on sides for the band) */
  --band-gap: 48px;
}
.team-card::before{ content:""; display:none; }
.team-card .team-photo{ width:100%; padding:18px 10px 0; box-sizing:border-box; position:relative; z-index:3; height:320px; overflow:hidden; }
.team-card .team-photo img{ position:relative; z-index:3; width:100%; height:100%; object-fit:cover; border-radius:6px; display:block; }

/* Strong override to cancel Masonry or other scripts that set absolute positioning */
#aboutnlm-team .articles__item{ position:static !important; top:auto !important; left:auto !important; transform:none !important; width:auto !important; }
#aboutnlm-team .articles__col{ display:grid !important; }
.team-card .articles__item-link{ display:none !important; }
.team-card .team-info{ position:static; width:100%; display:flex; flex-direction:column; align-items:center; gap:8px; text-decoration:none; padding:16px; box-sizing:border-box; }
.team-card .team-info h3{ margin:0; font:600 18px/22px var(--nlm-font-sans, system-ui, Arial); text-transform:uppercase; color:#FFFFFF; text-align:center; }
.team-card .team-info p{ margin:0; font:400 14px/17px var(--nlm-font-sans, system-ui, Arial); color:rgba(255,255,255,0.9); text-align:center; }
.team-card .team-info .team-cert{ font:700 16px/20px var(--nlm-font-sans, system-ui, Arial); color:#FFEA3B; }
.team-card .team-info .team-underline{ font-weight:700; font-size:18px; line-height:22px; text-decoration:underline; color:rgba(255,255,255,0.95); }
.team-card .team-info h3{ text-transform:uppercase; }
.team-card-actions{ display:flex; justify-content:center; padding-bottom:12px; }
.team-card-btn{ display:inline-block; background:transparent; color:#fff; border:1px solid rgba(255,255,255,.16); padding:8px 12px; border-radius:6px; font-weight:700; font-size:14px; text-decoration:none; }
.team-card-btn:hover{ background:rgba(255,255,255,.04); }
.team-card .team-socials{ position:static; width:100%; display:flex; align-items:center; justify-content:center; gap:10px; padding-bottom:16px; box-sizing:border-box; }
.team-card .team-socials a{ width:36px; height:36px; border-radius:6px; background:#ffffff; display:inline-flex; align-items:center; justify-content:center; }
.team-card .team-socials svg{ width:18px; height:18px; color: var(--nl-dark, #173750); }

@media (max-width: 1139px){
  .team-section .articles__col{ grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px){
  .team-section .articles__col{ grid-template-columns: 1fr; padding:18px; }
  .team-title{ padding-left:18px; }
  .team-card{ min-height: auto; }
  .team-card::before{ display:block; top:72px; height:115px; }
  .team-card .team-photo img{ max-height:260px; }
}

/* Desktop: exactly 3 cards per row */
@media (max-width: 1139px){
  .team-card{ flex-basis: calc((100% - 25px)/2); }
}
@media (max-width: 768px){
  .team-card{ flex-basis: 100%; }
}
.team-section .row{ margin-left:0 !important; margin-right:0 !important; }
.team-sizer, .team-gutter-sizer{ display:none; }
</style>

<!-- Masonry script removed to fix mobile layout conflicts -->
<style>
/* === [NEW RESPONSIVE TEAM CARD STYLES] === */

/* This is a targeted reset. It's safer than `all: revert` which can have broad side effects. */
#aboutnlm-team .team-card,
#aboutnlm-team .articles__col,
#aboutnlm-team .team-photo,
#aboutnlm-team .team-photo img {
    position: static !important;
    height: auto !important;
    width: auto !important;
    top: auto !important;
    left: auto !important;
    transform: none !important;
    margin: 0 !important;
    padding: 0 !important;
    background: none !important;
    border: none !important;
    box-shadow: none !important;
}


/* New styles */
#aboutnlm-team .articles__col {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
    gap: 30px !important;
    padding: 30px 0 !important;
}

#aboutnlm-team .team-card {
    background: #173750 !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    display: flex !important;
    flex-direction: column !important;
    height: 100% !important;
    box-shadow: 0 6px 18px rgba(11,47,73,.12) !important;
}

#aboutnlm-team .team-card .team-photo {
    width: 100% !important;
    padding: 18px 10px 0 !important;
    box-sizing: border-box !important;
    height: 320px !important;
}

#aboutnlm-team .team-card .team-photo img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    border-radius: 6px !important;
}

#aboutnlm-team .team-card .team-info-desktop {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 16px !important;
    text-align: center !important;
    color: white !important;
    flex-grow: 1 !important;
}

#aboutnlm-team .team-card .team-info-desktop h3 {
    font: 600 18px/22px 'Inter', system-ui, Arial !important;
    text-transform: uppercase !important;
    color: #FFFFFF !important;
    margin: 0 !important;
}

#aboutnlm-team .team-card .team-info-desktop p {
    font: 400 14px/17px 'Inter', system-ui, Arial !important;
    color: rgba(255,255,255,0.9) !important;
    margin: 0 !important;
}

#aboutnlm-team .team-card .team-info-desktop .team-card-actions {
    margin-top: auto !important;
    padding-top: 10px !important;
}

#aboutnlm-team .team-card .team-info-desktop .team-card-btn {
    display: inline-block !important;
    background: transparent !important;
    color: #fff !important;
    border: 1px solid rgba(255,255,255,.16) !important;
    padding: 8px 12px !important;
    border-radius: 6px !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    text-decoration: none !important;
}

#aboutnlm-team .team-card .team-info-desktop .team-socials {
    display: flex !important;
    gap: 10px !important;
    padding-top: 10px !important;
}

#aboutnlm-team .team-card .team-info-mobile {
    display: none !important;
}

@media (max-width: 767px) {
    #aboutnlm-team .articles__col {
        grid-template-columns: 1fr !important;
        justify-items: center !important;
        gap: 20px !important;
        padding: 20px 0 !important;
    }

    #aboutnlm-team .team-card {
        width: 164px !important;
        height: 324px !important;
        background-color: #FFFFFF !important;
        position: relative !important; /* Needed for info block positioning */
        overflow: hidden !important; /* prevent overlaps/gaps */
    }

    #aboutnlm-team .team-card .team-photo {
        padding: 0 !important;
        height: auto !important;
        margin-top: 15px !important;
        display:flex !important; align-items:center !important; justify-content:center !important;
    }

    #aboutnlm-team .team-card .team-photo img {
        width: 129.32px !important;
        height: 162px !important;
        border-radius: 0 !important;
        display:block !important;
    }

    #aboutnlm-team .team-card .team-info-desktop {
        display: none !important;
    }

    #aboutnlm-team .team-card .team-info-mobile {
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-start !important;
        align-items: center !important;
        text-align: center !important;
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 147px !important;
        background-color: #173750 !important;
        color: white !important;
        padding: 20px 9px 15px 9px !important;
        gap: 4px !important;
        z-index: 2 !important;
    }

    #aboutnlm-team .team-card .team-info-mobile h3 {
        font-weight: bold !important;
        font-size: 16px !important;
        color: white !important;
        margin: 0 !important;
        text-transform: none !important;
    }

    #aboutnlm-team .team-card .team-info-mobile p {
        font-size: 13px !important;
        color: white !important;
        margin: 0 !important;
    }

    #aboutnlm-team .team-card .team-info-mobile .social-icons {
        display: flex !important;
        gap: 10px !important;
        margin-top: auto !important;
        padding-bottom: 10px !important;
    }
    
    #aboutnlm-team .team-card .team-info-mobile .social-icons a {
        background-color: #FFFFFF !important;
        border-radius: 6px !important;
    }
    
    #aboutnlm-team .team-card .team-info-mobile .social-icons svg {
        color: #173750 !important;
    }
}
</style>
