<?php
/**
 * @var $openLogin
 */

/* Предотвратим случайное переключение шаблона в контроллере */
$this->layout = false;
Yii::app()->ads->addVerificationTags();

$cs = Yii::app()->clientScript;
$cs
    ->registerCssFile('/lite/css/min/homepage.css')
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
            <header class="header header__redesign">
                <?php $this->renderPartial('//_header'); ?>
            </header>
            <style>
                body #ya-site-form0 .ya-site-suggest-list {
                    background-color: #fff;
                }
            </style>
            <!-- header-->
        </div>
        <script>
            /*меню юзера*/
            $(function () {
                /*меню юзера*/
                var $window = $(window);
                $window.resize(function resize(){
                    if ($window.width() < 1025) {
                        $('.js-ava__link').off('click');
                        $('.js-ava__link,.js-overlay-user').on('click', function () {
                            $('.user-widget-block,.js-overlay-user').toggleClass('user-widget-block_open');
                            if ($('.header__menu').hasClass('header__menu_open')) {
                                $('.header__menu, .js-overlay-menu').removeClass('header__menu_open');
                            }
                        });
                    }else{
                        $('.js-ava__link').off('click');
                        $('.js-ava__link').on('click', function () {
                            $('.user-widget-block').toggleClass('user-widget-block_open');
                            if ($('.header__menu').hasClass('header__menu_open')) {
                                $('.header__menu').removeClass('header__menu_open');
                            }
                        });
                    }
                }).trigger('resize');

                /*Мобильное меню*/
                $('.mobile-menu, .js-overlay-menu').on('click', function () {
                    $('.header__menu, .js-overlay-menu').toggleClass('header__menu_open');
                    if ($('.user-widget-block').hasClass('user-widget-block_open')) {
                        $('.user-widget-block, .js-overlay-user').removeClass('user-widget-block_open');
                    }
                });
            });
        </script>
        <div class="js-overlay-menu overlay-menu"></div>
        <div class="js-overlay-user overlay-user"></div>
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
