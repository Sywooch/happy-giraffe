<?php
/**
 * @var PersonalAreaController $this
 */
?>
<!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
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
        });

        function PediatorMenu() {
            /*Мобильное меню педиатора*/
            if ($('.pediator-menu').hasClass('js-pediator-menu')){

                $('.overlay-menu').removeClass('js-overlay-menu ');

                $('.js-pediator-menu, .js-overlay-pediator').on('click', function () {
                    $('.js-overlay-pediator').toggleClass('header__menu_open');
                    $('.pediator-nav__wrapper').toggleClass('pediator-nav__wrapper--active');
                    $('body').toggleClass('overflow-y');
                });
            }
        }

        setTimeout(PediatorMenu, 2000);

    </script>
    <div class="js-overlay-menu overlay-menu js-overlay-pediator"></div>
    <div class="js-overlay-user overlay-user"></div>
<?php Yii::app()->ads->showCounters(); ?>
<?php if (Yii::app()->user->checkAccess('editMeta')):?>
    <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
<?php endif ?>
<div class="layout-container pediator">
    <?php $this->renderPartial('//_alerts'); ?>

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
<?php

// TODO: Временное решение скрыть данный css с педиатра для врачей
if ($this->getModule()->getId() != 'specialists/pediatrician')
    Yii::app()->clientScript->registerCssFile('/app/builds/static/css/separate-css-sample.css');

Yii::app()->clientScript->registerCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');

?>
</body></html>
