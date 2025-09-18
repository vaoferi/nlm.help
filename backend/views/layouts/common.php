<?php
/**
 * @var $this yii\web\View
 * @var $content string
 */

use backend\assets\BackendAsset;
use backend\modules\system\models\SystemLog;
use backend\widgets\Menu;
use common\models\TimelineEvent;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;

$bundle = BackendAsset::register($this);

?>

<?php $this->beginContent('@backend/views/layouts/base.php'); ?>
<?php
$this->registerJs(<<<'JS'
(function($){
  // Robust tab switcher: works even if $.fn.tab is unavailable
  $(document).on('click', 'ul.nav-tabs li a', function(e){
    var $a = $(this);
    var href = $a.attr('href');
    if (!href || href.charAt(0) !== '#') return;
    e.preventDefault();
    var $tabs = $a.closest('ul.nav-tabs');
    $tabs.find('li').removeClass('active');
    $a.parent().addClass('active');
    var $content = $tabs.nextAll('.tab-content').first();
    if ($content.length) {
      $content.find('.tab-pane').removeClass('active');
      $content.find(href).addClass('active');
    } else {
      // fallback global
      $('.tab-content .tab-pane').removeClass('active');
      $(href).addClass('active');
    }
  });
})(jQuery);
JS
);
?>

<div class="wrapper">
    <!-- header logo: style can be found in header.less -->
    <header class="main-header">
        <a href="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl('/') ?>" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <?php echo Yii::$app->name ?>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only"><?php echo Yii::t('backend', 'Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo Url::to(['/dashboard/default/index']) ?>" class="btn btn-warning navbar-btn" style="margin-right:10px; font-weight:700; color:#111;">
                            🚀 <?php echo Yii::t('backend', 'Try new design (Beta)') ?>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo strtoupper(Yii::$app->language) ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach (Yii::$app->params['availableLocales'] as $code => $label): ?>
                                <li>
                                    <a href="<?php echo Url::to(['/language/set', 'lang' => $code, 'return' => Yii::$app->request->url]) ?>"><?php echo strtoupper($label) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li id="timeline-notifications" class="notifications-menu">
                        <a href="<?php echo Url::to(['/timeline-event/index']) ?>">
                            <i class="fa fa-bell"></i>
                            <span class="label label-success">
                                <?php echo TimelineEvent::find()->today()->count() ?>
                            </span>
                        </a>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li id="log-dropdown" class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-warning"></i>
                            <span class="label label-danger">
                                <?php echo SystemLog::find()->count() ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo Yii::t('backend', 'You have {num} log items', ['num' => SystemLog::find()->count()]) ?></li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php foreach (SystemLog::find()->orderBy(['log_time' => SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                        <li>
                                            <a href="<?php echo Yii::$app->urlManager->createUrl(['/system/log/view', 'id' => $logEntry->id]) ?>">
                                                <i class="fa fa-warning <?php echo $logEntry->level === Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                                <?php echo $logEntry->category ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li class="footer">
                                <?php echo Html::a(Yii::t('backend', 'View all'), ['/system/log/index']) ?>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>"
                                 class="user-image">
                            <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header light-blue">
                                <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>"
                                     class="img-circle" alt="User Image"/>
                                <p>
                                    <?php echo Yii::$app->user->identity->username ?>
                                    <small>
                                        <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                    </small>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?php echo Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                                <div class="pull-left">
                                    <?php echo Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                                <div class="pull-right">
                                    <?php echo Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <?php echo Html::a('<i class="fa fa-cogs"></i>', ['/system/settings']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>"
                         class="img-circle"/>
                </div>
                <div class="pull-left info">
                    <p><?php echo Yii::t('backend', 'Hello, {username}', ['username' => Yii::$app->user->identity->getPublicIdentity()]) ?></p>
                    <a href="<?php echo Url::to(['/sign-in/profile']) ?>">
                        <i class="fa fa-circle text-success"></i>
                        <?php echo Yii::$app->formatter->asDatetime(time()) ?>
                    </a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <?php echo Menu::widget([
                'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
                'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                'activateParents' => true,
                'items' => [
                    [
                        'label' => Yii::t('backend', 'Main'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('backend', 'Timeline'),
                        'icon' => '<i class="fa fa-bar-chart-o"></i>',
                        'url' => ['/timeline-event/index'],
                        'badge' => TimelineEvent::find()->today()->count(),
                        'badgeBgClass' => 'label-success',
                    ],
                    [
                        'label' => Yii::t('backend', 'Users'),
                        'icon' => '<i class="fa fa-users"></i>',
                        'url' => ['/user/index'],
                        'active' => Yii::$app->controller->id === 'user',
                        'visible' => Yii::$app->user->can('administrator'),
                    ],
                    [
                        'label' => Yii::t('backend', 'Content'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('backend', 'СМИ'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-newspaper-o"></i>',
                        'options' => ['class' => 'treeview'],
//                        'active' => (Yii::$app->controller->module->id == 'slider'),
                        'active' => 'content' === Yii::$app->controller->module->id &&
                            in_array(Yii::$app->controller->id, ['smi', 'catalog-smi']),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Публикации'),
                                'url' => ['/content/smi/index'],
                                'icon' => '<i class="fa fa-newspaper-o"></i>',
                                'active' => Yii::$app->controller->id === 'smi',
                            ],
                            [
                                'label' => Yii::t('backend', 'Каталог СМИ'),
                                'url' => ['/content/catalog-smi/index'],
                                'icon' => '<i class="fa fa-folder-open-o"></i>',
                                'active' => Yii::$app->controller->id === 'catalog-smi',
                            ],
                        ],
                    ],
//                    [
//                        'label' => Yii::t('backend', 'Static pages'),
//                        'url' => ['/content/page/index'],
//                        'icon' => '<i class="fa fa-thumb-tack"></i>',
//                        'active' => Yii::$app->controller->id === 'page',
//                    ],
                    [
                        'label' => Yii::t('backend', 'Projects'),
                        'url' => ['/content/project/index'],
                        'icon' => '<i class="fa fa-sign-language"></i>',
                        'active' => Yii::$app->controller->id === 'project',
                    ],
                    [
                        'label' => Yii::t('backend', 'Photo Albums'),
                        'url' => ['/content/photo-album/index'],
                        'icon' => '<i class="fa fa-folder-open-o"></i>',
                        'active' => Yii::$app->controller->id === 'photo-album',
                    ],
//                    [
//                        'label' => Yii::t('backend', 'Magazine'),
//                        'url' => ['/content/magazine/index'],
//                        'icon' => '<i class="fa fa-newspaper-o"></i>',
//                        'active' => Yii::$app->controller->id === 'magazine',
//                    ],
                    [
                        'label' => Yii::t('backend', 'Videos'),
                        'url' => ['/content/video/index'],
                        'icon' => '<i class="fa fa-youtube"></i>',
                        'active' => Yii::$app->controller->id === 'video',
                    ],
                    [
                        'label' => Yii::t('backend', 'Articles'),
                        'url' => ['/content/article/index'],
                        'icon' => '<i class="fa fa-file-o"></i>',
                        'active' => Yii::$app->controller->id === 'article',
                    ],
                    [
                        'label' => Yii::t('backend', 'Categories'),
                        'url' => ['/content/category/index'],
                        'icon' => '<i class="fa fa-folder-open-o"></i>',
                        'active' => Yii::$app->controller->id === 'category',
                    ],
                    [
                        'label' => Yii::t('backend', 'Help Centers'),
                        'url' => ['/content/help-center/index'],
                        'icon' => '<i class="fa fa-handshake-o"></i>',
                        'active' => Yii::$app->controller->id === 'help-center',
                    ],
                    [
                        'label' => Yii::t('backend', 'Sliders'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-picture-o"></i>',
                        'options' => ['class' => 'treeview'],
//                        'active' => (Yii::$app->controller->module->id == 'slider'),
                        'active' => 'content' === Yii::$app->controller->module->id &&
                            in_array(Yii::$app->controller->id, ['slider', 'partner', 'slider-sertificat']),

                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Sliders'),
                                'url' => ['/content/slider/index'],
                                'icon' => '<i class="fa fa-picture-o"></i>',
                                'active' => Yii::$app->controller->id === 'slider',
                            ],
                            [
                                'label' => Yii::t('backend', 'Partners'),
                                'url' => ['/content/partner/index'],
                                'icon' => '<i class="fa fa-handshake-o"></i>',
                                'active' => Yii::$app->controller->id === 'partner',
                            ],
                            [
                                'label' => Yii::t('backend', 'Sliders').' сертификаты',
                                'url' => ['/content/slider-sertificat/index'],
                                'icon' => '<i class="fa fa-picture-o"></i>',
                                'active' => Yii::$app->controller->id === 'slider-sertificat',
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend', 'Contact Form'),
                        'url' => ['/contact/default/index'],
                        'icon' => '<i class="fa fa-address-card"></i>',
                        'active' => Yii::$app->controller->module->id === 'contact',
                    ],
                    [
                        'label' => Yii::t('backend', 'Testimonials'),
                        'url' => ['/content/testimonial/index'],
                        'icon' => '<i class="fa fa-users"></i>',
                        'active' => Yii::$app->controller->id === 'testimonial',
                    ],
                    [
                        'label' => Yii::t('backend', 'Payments'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-money"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => (Yii::$app->controller->module->id == 'payments'),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Project'),
                                'url' => ['/payments/order-project/index'],
                                'icon' => '<i class="fa fa-database"></i>',
                                'active' => (Yii::$app->controller->id == 'order-project'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Categories'),
                                'url' => ['/payments/order-category/index'],
                                'icon' => '<i class="fa fa-database"></i>',
                                'active' => (Yii::$app->controller->id == 'order-category'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Service'),
                                'url' => ['/payments/order-service/index'],
                                'icon' => '<i class="fa fa-database"></i>',
                                'active' => (Yii::$app->controller->id == 'order-service'),
                            ],
                        ],
                    ],
                    [
                            'label' => Yii::t('backend', 'Social Networks'),
                            'url' => '#',
                            'options' => ['class' => 'treeview'],
                            'active' => (Yii::$app->controller->id == 'auth'),
                            'icon' => '<i class="fa fa-users"></i>',
                            'items' => [
                                // VK removed per security policy
                                [
                                    'label' => Yii::t('backend', 'Facebook'),
                                    'url' => ['/auth/fb'],
                                    'icon' => '<i class="fa fa-facebook"></i>',
                                    'active' => (Yii::$app->controller->id == 'auth'),
                                ],
                                // OK removed per security policy
                            ],
                    ],
                    [
                        'label' => Yii::t('backend', 'Widgets'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-code"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => Yii::$app->controller->module->id === 'widget',
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Text Blocks'),
                                'url' => ['/widget/text/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                                'active' => Yii::$app->controller->id === 'text',
                            ],
//                            [
//                                'label' => Yii::t('backend', 'Menu'),
//                                'url' => ['/widget/menu/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                                'active' => Yii::$app->controller->id === 'menu',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Carousel'),
//                                'url' => ['/widget/carousel/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                                'active' => in_array(Yii::$app->controller->id, ['carousel', 'carousel-item']),
//                            ],
                        ],
                    ],
//                    [
//                        'label' => Yii::t('backend', 'Translation'),
//                        'options' => ['class' => 'header'],
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'Translation'),
//                        'url' => ['/translation/default/index'],
//                        'icon' => '<i class="fa fa-language"></i>',
//                        'active' => (Yii::$app->controller->module->id == 'translation'),
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'System'),
//                        'options' => ['class' => 'header'],
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'RBAC Rules'),
//                        'url' => '#',
//                        'icon' => '<i class="fa fa-flag"></i>',
//                        'options' => ['class' => 'treeview'],
//                        'active' => in_array(Yii::$app->controller->id, ['rbac-auth-assignment', 'rbac-auth-item', 'rbac-auth-item-child', 'rbac-auth-rule']),
//                        'items' => [
//                            [
//                                'label' => Yii::t('backend', 'Auth Assignment'),
//                                'url' => ['/rbac/rbac-auth-assignment/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Auth Items'),
//                                'url' => ['/rbac/rbac-auth-item/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Auth Item Child'),
//                                'url' => ['/rbac/rbac-auth-item-child/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Auth Rules'),
//                                'url' => ['/rbac/rbac-auth-rule/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                        ],
//                    ],
                    [
                        'label' => Yii::t('backend', 'Files'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-th-large"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => (Yii::$app->controller->module->id == 'file'),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Storage'),
                                'url' => ['/file/storage/index'],
                                'icon' => '<i class="fa fa-database"></i>',
                                'active' => (Yii::$app->controller->id == 'storage'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Manager'),
                                'url' => ['/file/manager/index'],
                                'icon' => '<i class="fa fa-television"></i>',
                                'active' => (Yii::$app->controller->id == 'manager'),
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend', 'Key-Value Storage'),
                        'url' => ['/system/key-storage/index'],
                        'icon' => '<i class="fa fa-arrows-h"></i>',
                        'active' => (Yii::$app->controller->id == 'key-storage'),
                    ],
                    [
                        'label' => Yii::t('backend', 'Cache'),
                        'url' => ['/system/cache/index'],
                        'icon' => '<i class="fa fa-refresh"></i>',
                    ],
//                    [
//                        'label' => Yii::t('backend', 'System Information'),
//                        'url' => ['/system/information/index'],
//                        'icon' => '<i class="fa fa-dashboard"></i>',
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'Logs'),
//                        'url' => ['/system/log/index'],
//                        'icon' => '<i class="fa fa-warning"></i>',
//                        'badge' => SystemLog::find()->count(),
//                        'badgeBgClass' => 'label-danger',
//                    ],
                ],
            ]); ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $this->title ?>
                <?php if (isset($this->params['subtitle'])): ?>
                    <small><?php echo $this->params['subtitle'] ?></small>
                <?php endif; ?>
            </h1>

            <?php echo Breadcrumbs::widget([
                'tag' => 'ol',
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if (Yii::$app->session->hasFlash('alert')): ?>
                <?php echo Alert::widget([
                    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                ]) ?>
            <?php endif; ?>
            <?php echo $content ?>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $this->endContent(); ?>
