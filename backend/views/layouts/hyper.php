<?php
use backend\assets\HyperAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

HyperAsset::register($this);
?>
<?php
$user = Yii::$app->user;
$isGuest = $user->isGuest;
$username = (!$isGuest && $user->identity) ? $user->identity->username : 'Guest';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language ?>" data-bs-theme="light" data-menu-color="dark" data-topbar-color="dark">

<head>
    <meta charset="<?=Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <style>
      :root{
        --ct-primary:#002E5D; /* dark blue */
        --ct-info:#009FE3;    /* accent blue */
        --ct-gray-500:#B4B4B4;/* neutral gray */
        --ct-body-bg:#FFFFFF; /* white background */
        --ct-link-color:#009FE3;
      }
      .navbar-custom, .topbar{background-color:#002E5D!important}
      .leftside-menu{background:#0f1f33}
      .side-nav .side-nav-link{color:#e6eef8}
      .side-nav .side-nav-link:hover,.side-nav .side-nav-link.active{color:#fff}
      .breadcrumb .breadcrumb-item>a{color:#009FE3}
      .btn-primary{background-color:#002E5D;border-color:#002E5D}
      .btn-outline-primary{color:#002E5D;border-color:#002E5D}
      .btn-outline-primary:hover{background:#002E5D;border-color:#002E5D}
    </style>
</head>

<body>
<?php $this->beginBody() ?>
    <!-- Begin page -->
    <div class="wrapper">

        
        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-lg-2 gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="/" class="logo-light">
                            <span class="logo-lg">
                                <img src="/images/logo.png" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="/" class="logo-dark">
                            <span class="logo-lg">
                                <img src="/images/logo-dark.png" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="/images/logo-dark-sm.png" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Buttons -->
                    <button class="btn btn-sm btn-outline-light d-none d-md-inline-flex align-items-center me-1 button-toggle-menu" aria-label="Переключить меню" title="Скрыть/показать меню">
                        ☰
                    </button>
                    <button class="btn btn-sm btn-outline-light d-inline-flex d-md-none ms-2 align-items-center" data-toggle="sidenav" aria-label="Меню" title="Меню">
                        ☰ Меню
                    </button>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="/images/users/avatar-1.jpg" alt="user-image" width="32" class="rounded-circle">
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0"><?= Html::encode($username) ?></h5>
                                <h6 class="my-0 fw-normal"><?= $isGuest ? 'Гость' : 'Администратор' ?></h6>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Добро пожаловать!</h6>
                            </div>
                            <?php if (!$isGuest): ?>
                                <a href="<?= \yii\helpers\Url::to(['/sign-in/profile']) ?>" class="dropdown-item">
                                    <i class="ri-user-smile-line font-16 me-1"></i>
                                    <span>Профиль</span>
                                </a>
                                <a href="<?= \yii\helpers\Url::to(['/sign-in/logout']) ?>" class="dropdown-item" data-method="post">
                                    <i class="ri-login-circle-line font-16 me-1"></i>
                                    <span>Выйти</span>
                                </a>
                            <?php else: ?>
                                <a href="<?= \yii\helpers\Url::to(['/sign-in/login']) ?>" class="dropdown-item">
                                    <i class="ri-login-circle-line font-16 me-1"></i>
                                    <span>Войти</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php if (!$isGuest): ?>
            <div class="leftside-menu">
                <div class="h-100" id="leftside-menu-container" data-simplebar>
                    <!--- Sidemenu -->
                <ul class="side-nav">
                    <li class="side-nav-title">Навигация</li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/dashboard/default/index']) ?>" class="side-nav-link"><i class="uil-home-alt"></i><span> 🏠 Главная </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/article/index']) ?>" class="side-nav-link"><i class="uil-comments-alt"></i><span> 🗞️ Статьи </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/category/index']) ?>" class="side-nav-link"><i class="uil-folder"></i><span> 🗂️ Категории </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/page/index']) ?>" class="side-nav-link"><i class="uil-file-alt"></i><span> 📄 Страницы </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/project/index']) ?>" class="side-nav-link"><i class="uil-briefcase"></i><span> 📦 Проекты </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/partner/index']) ?>" class="side-nav-link"><i class="uil-users-alt"></i><span> 🤝 Партнёры </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/video/index']) ?>" class="side-nav-link"><i class="uil-video"></i><span> 🎥 Видео </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/slider/index']) ?>" class="side-nav-link"><i class="uil-image"></i><span> 🖼️ Слайдер </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/slider-sertificat/index']) ?>" class="side-nav-link"><i class="uil-award"></i><span> 🏅 Сертификаты </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/help-center/index']) ?>" class="side-nav-link"><i class="uil-life-ring"></i><span> 🆘 Центры помощи </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/photo-album/index']) ?>" class="side-nav-link"><i class="uil-images"></i><span> 📸 Фотоальбомы </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/testimonial/index']) ?>" class="side-nav-link"><i class="uil-comment-info"></i><span> 💬 Отзывы </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/content/magazine/index']) ?>" class="side-nav-link"><i class="uil-newspaper"></i><span> 📰 Журналы </span></a></li>
                    <li class="side-nav-title">Система</li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/file/storage/index']) ?>" class="side-nav-link"><i class="uil-cloud-upload"></i><span> 📁 Файлы </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/widget/menu/index']) ?>" class="side-nav-link"><i class="uil-apps"></i><span> 🧩 Виджеты </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/system/settings']) ?>" class="side-nav-link"><i class="uil-cog"></i><span> ⚙️ Настройки </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/translation/default/index']) ?>" class="side-nav-link"><i class="uil-translate"></i><span> 🌐 Переводы </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/rbac/rbac-auth-item/index']) ?>" class="side-nav-link"><i class="uil-shield-check"></i><span> 🛡️ Права (RBAC) </span></a></li>
                    <li class="side-nav-item"><a href="<?= \yii\helpers\Url::to(['/user/index']) ?>" class="side-nav-link"><i class="uil-user"></i><span> 👤 Пользователи </span></a></li>
                </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        <?php endif; ?>
        <!-- ========== Left Sidebar End ========== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <?= Breadcrumbs::widget([
                                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                        'options' => ['class' => 'breadcrumb m-0'],
                                        'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
                                        'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
                                    ]) ?>
                                </div>
                                <h4 class="page-title"><?= Html::encode($this->title) ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    
                    <?= $content ?>

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>document.write(new Date().getFullYear())</script> © nlm.help
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

    </div>
    <!-- END wrapper -->

<script>
// Bootstrap tab fallback for links with data-bs-toggle or legacy markup
document.addEventListener('click', function(e){
  var a = e.target.closest('a[data-bs-toggle="tab"], ul.nav-tabs a');
  if (!a) return;
  var href = a.getAttribute('href');
  if (!href || href.charAt(0) !== '#') return;
  e.preventDefault();
  var li = a.parentElement;
  if (li && li.classList.contains('active') === false) {
    var ul = li.parentElement;
    ul.querySelectorAll('li').forEach(function(x){x.classList.remove('active')});
    li.classList.add('active');
  }
  var container = document.querySelector('.tab-content');
  if (container) {
    container.querySelectorAll('.tab-pane').forEach(function(x){x.classList.remove('active')});
    var pane = document.querySelector(href);
    if (pane) pane.classList.add('active');
  }
});
// Initialize any uninitialized Krajee Select2 widgets (BS5)
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('select[data-krajee-select2]').forEach(function(el){
    var $el = window.jQuery ? jQuery(el) : null;
    if (!$el || !$el.select2) return;
    var key = el.getAttribute('data-krajee-select2');
    var optKey = el.getAttribute('data-s2-options');
    try {
      var opts = (key && window[key]) ? window[key] : {};
      var s2opts = (optKey && window[optKey]) ? window[optKey] : {};
      var config = Object.assign({}, s2opts, opts);
      if (!$el.data('select2')) {
        $el.select2(config);
      }
    } catch (e) {}
  });
});

// Sidebar burger toggler (persist via sessionStorage to match Hyper config)
(function(){
  const html = document.documentElement;
  function setSize(val){
    html.setAttribute('data-sidenav-size', val);
    try {
      var cfg = window.config || {};
      cfg.sidenav = cfg.sidenav || {};
      cfg.sidenav.size = val;
      sessionStorage.setItem('__HYPER_CONFIG__', JSON.stringify(cfg));
      window.config = cfg;
    } catch(e){}
  }
  document.addEventListener('click', function(e){
    const btn = e.target.closest('[data-toggle="sidenav"], .button-toggle-menu');
    if(!btn) return;
    const cur = html.getAttribute('data-sidenav-size') || 'default';
    setSize(cur === 'condensed' ? 'default' : 'condensed');
  });
})();
</script>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
