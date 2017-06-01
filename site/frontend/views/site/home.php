<?php
/**
 * @var $openLogin
 */

/* Предотвратим случайное переключение шаблона в контроллере */
$this->layout = false;
Yii::app()->ads->addVerificationTags();

$cs = Yii::app()->clientScript;
$cs
    ->registerCssFile('/lite/css/dev/all.css')
    ->registerCssFile('http://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=cyrillic,latin')
;

if ($openLogin == 'register') {
    $cs->registerAmd('openLogin', array('RegisterForm' => 'signup/register-form'), 'RegisterForm.viewModel.prototype.open();');
}

if ($openLogin == 'login') {
    $cs->registerAmd('openLogin', array('LoginForm' => 'signup/login-form'), 'LoginForm.viewModel.prototype.open();');
}
?>
<?php $this->beginClip('home'); ?>
<div class="homepage-clubs_b">
    <div class="homepage-clubs_btn-hold"><a class="homepage_btn-sign btn btn-xxl registration-button" data-bind="follow: {}">Начни общаться!</a></div>
    <div class="homepage_desc-tx">узнавай новое, делись самым интересным </div>
</div>
<?php $this->endClip(); ?>
<!DOCTYPE html>
<!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <?php if (Yii::app()->vm->getVersion() != VersionManager::VERSION_DESKTOP): ?>
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php endif; ?>
    <title>Веселый Жираф - сайт для всей семьи</title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
</head>
<body class="body body__lite body__homepage <?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?>  ">
<?php Yii::app()->ads->showCounters(); ?>
<div class="layout-container <?= Yii::app()->vm->getVersion() == VersionManager::VERSION_DESKTOP ? 'homepage' : 'homepage-res' ?>">
    <?php $this->renderPartial('//_alerts'); ?>
    
    <div class="layout-loose layout-loose__white">
        <div class="layout-header">
            <!-- header-->
            <header class="header header__homepage">
                <div class="header_hold">
                    <div class="clearfix">
                        <div class="header-login"><a class="header-login_a login-button" data-bind="follow: {}">Вход</a><a class="header-login_a registration-button" data-bind="follow: {}">Регистрация</a></div>

                    <?php if (Yii::app()->vm->getVersion() == VersionManager::VERSION_DESKTOP): ?>
                        <?php if ($this->module === null || $this->module->id != 'search'): ?>
                            <div class="sidebar-search clearfix sidebar-search__big">
                                <!-- <input type="text" name="" placeholder="Поиск" class="sidebar-search_itx"> -->
                                <!-- При начале ввода добавить класс .active на кнопку-->
                                <!-- <button class="sidebar-search_btn"></button> -->
                                <?php $this->widget('site.frontend.modules.search.widgets.YaSearchWidget'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    </div>

                    <div class="header_row-home">
                        <!-- logo-->
                        <h1 class="logo logo__l"><span class="logo_i">Веселый жираф - сайт для всей семьи</span></h1>
                        <!-- /logo-->
                    </div>
                    <?php if (Yii::app()->vm->getVersion() != VersionManager::VERSION_DESKTOP): ?>
                        <?php if ($this->module === null || $this->module->id != 'search'): ?>
                            <div class="sidebar-search clearfix sidebar-search__big">
                                <!-- <input type="text" name="" placeholder="Поиск" class="sidebar-search_itx"> -->
                                <!-- При начале ввода добавить класс .active на кнопку-->
                                <!-- <button class="sidebar-search_btn"></button> -->
                                <?php $this->widget('site.frontend.modules.search.widgets.YaSearchWidget'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </header>
            <style>
                body #ya-site-form0 .ya-site-suggest-list {
                    background-color: #fff;
                }
            </style>
            <!-- header-->
        </div>
        <div class="layout-loose_hold clearfix">
            <div class="homepage-desc">
                <div class="homepage-desc_hold">
                    <div class="homepage-desc_b clearfix">
                        <div class="homepage-desc_l">Веселый Жираф - это социальная сеть<br><span class="homepage-desc_mark">для всей семьи</span>, которая собрала <br>миллионы мам и пап со всей  России</div>
                        <div class="homepage-desc_r"><a class="homepage_btn-sign btn btn-success btn-xxl registration-button" data-bind="follow: {}">Присоединяйся!</a>
                            <div class="homepage-desc_soc">
                                <span class="i-or-tx">или войти с помощью</span>
                                <!-- <span class="ico-social-hold"><a href="#" class="ico-social ico-social__m ico-social__odnoklassniki"></a><a href="#" class="ico-social ico-social__m ico-social__vkontakte"></a></span> -->
                                <?php $this->widget('AuthWidget', array('action' => '/signup/login/social', 'view' => 'simple')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (Yii::app()->vm->getVersion() == VersionManager::VERSION_DESKTOP): ?>
                <?php $this->renderPartial('_home_clubs'); ?>
                <?php $this->renderPartial('_home_posts'); ?>
            <?php else: ?>
                <?php $this->renderPartial('_home_posts'); ?>
                <?php $this->renderPartial('_home_clubs'); ?>
            <?php endif; ?>

            <?php
            $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
                'pageVar' => 'page',
                'view' => 'onair',
                'pageSize' => 5,
            ));
            ?>

            <!-- Посетители-->
            <div class="homepage_row">
                <div class="homepage-counter">
                    <div class="homepage_title"> Нас посетило уже! </div>
                    <?php $this->widget('application.widgets.home.CounterWidget'); ?>
                    <div class="homepage_desc-tx">будущих и настоящих мам и пап</div><a class="homepage_btn-sign btn btn-success btn-xxl registration-button" data-bind="follow: {}">Присоединяйся!</a>
                </div>
            </div>
            <!-- /Посетители-->

            <?php $this->renderPartial('//_footer'); ?>

        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerCssFile('/app/builds/static/css/separate-css-sample.css');
Yii::app()->clientScript->registerCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');
?>
</body>
</html>
