<?php
/**
 * @var PersonalAreaController $this
 */
?><!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <?php if ($this->adaptive): ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php endif; ?>
    <title><?=$this->pageTitle?></title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
</head>
<body class="body body__lite theme body__bg2 body_competition<?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?> <?php if (Yii::app()->user->isGuest): ?> body__guest <?php endif; ?>">
    <script>

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

            /*Мобильное меню*/
            $('.js-pediator-menu').on('click', function () {
                console.log( 'done' );
                //$('.js-overlay-menu').toggleClass('header__menu_open');
                $('.pediator-nav__wrapper').toggleClass('pediator-nav__wrapper--active');
                $('body').toggleClass('overflow-y');
            });
        });
    </script>
    <div class="js-overlay-menu overlay-menu"></div>
    <div class="js-overlay-user overlay-user"></div>
<?php Yii::app()->ads->showCounters(); ?>
<?php if (Yii::app()->user->checkAccess('editMeta')):?>
    <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
<?php endif ?>
<div class="layout-container">

	<div id="js-alerts" class="alerts" data-bind="template: { name: 'alert', foreach: alertsList }"></div>
        
    <script type="text/html" id="alert">
	   <div class="alert alert-in" data-bind="css: 'alert-' + color">
            <div class="position-rel">
                <div class="alert__container">
                    <div class="alert__ico" data-bind="css: 'alert__ico-' + color"></div>
                    <div class="alert__text" data-bind="css: 'alert__text-' + color, text: message"></div>
                </div>
                <span class="alert__close" data-bind="click: $parent.closeAlert, css: 'alert__close-' + color"></span>
            </div>
        </div>
    </script>
    
    <div class="layout-loose layout-loose__white">
        <?= $content ?>
        <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
    </div>
</div>
<div class="popup-container display-n">
</div>
<!--[if lt IE 9]> <script type="text/javascript" src="/lite/javascript/respond.min.js"></script> <![endif]-->
<script type="text/javascript">
    require(['lite']);
</script>
<?php if (Yii::app()->user->isGuest): ?>
    <?php $this->widget('site.frontend.modules.signup.widgets.LayoutWidget'); ?>
<?php endif; ?>

<?php if (false): ?>
<?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adfox')); ?>
<!--AdFox START-->
<!--giraffe-->
<!--Площадка: Весёлый Жираф / * / *-->
<!--Тип баннера: Fullscreen Mobile-->
<!--Расположение: <верх страницы>-->
<script type="text/javascript">
    <!--
    if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 4294967295) + 1; }
    if (typeof(document.referrer) != 'undefined') {
        if (typeof(afReferrer) == 'undefined') {
            afReferrer = encodeURIComponent(document.referrer);
        }
    } else {
        afReferrer = '';
    }
    var addate = new Date();
    var scrheight = '', scrwidth = '';
    if (self.screen) {
        scrwidth = screen.width;
        scrheight = screen.height;
    } else if (self.java) {
        var jkit = java.awt.Toolkit.getDefaultToolkit();
        var scrsize = jkit.getScreenSize();
        scrwidth = scrsize.width;
        scrheight = scrsize.height;
    }
    document.write('<scr' + 'ipt type="text/javascript" src="//ads.adfox.ru/211012/prepareCode?pp=g&amp;ps=bkqy&amp;p2=evcc&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
    // -->
</script>
<!--AdFox END-->
<?php $this->endWidget(); ?>
<?php endif; ?>

<?php if (Yii::app()->vm->getVersion() == VersionManager::VERSION_MOBILE): ?>
    <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'mailru')); ?>
    <script type="text/javascript">
        mailru_ad_client = "ad-46399";
        mailru_ad_slot = 46399;
    </script>
    <script type="text/javascript" src="//rs.mail.ru/static/ads-min.js"></script>
    <?php $this->endWidget(); ?>
<?php endif; ?>

</body></html>