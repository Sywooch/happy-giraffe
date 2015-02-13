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
<!DOCTYPE html>
<!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>Веселый Жираф - сайт для всей семьи</title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>

    <script type='text/javascript'>
        var googletag = googletag || {};
        googletag.cmd = googletag.cmd || [];
        (function() {
            var gads = document.createElement('script');
            gads.async = true;
            gads.type = 'text/javascript';
            var useSSL = 'https:' == document.location.protocol;
            gads.src = (useSSL ? 'https:' : 'http:') +
            '//www.googletagservices.com/tag/js/gpt.js';
            var node = document.getElementsByTagName('script')[0];
            node.parentNode.insertBefore(gads, node);
        })();
    </script>

    <script type='text/javascript'>
        googletag.cmd.push(function() {
            googletag.pubads().addEventListener('slotRenderEnded', function(event) {
                require(['iframeResizer'], function(resizer) {
                   // $('#' + event.slot.b.d).find('iframe').iFrameResize({ heightCalculationMethod: 'lowestElement', checkOrigin: false, autoResize: false });
                });
            });
            googletag.defineSlot('/51841849/anounce_big', [615, 450], 'div-gpt-ad-1423826092090-0').addService(googletag.pubads());
            googletag.defineSlot('/51841849/anounce_photo', [300, 450], 'div-gpt-ad-1423826092090-1').addService(googletag.pubads());
            googletag.defineSlot('/51841849/anounce_small', [300, 315], 'div-gpt-ad-1423826092090-2').addService(googletag.pubads());
            googletag.defineSlot('/51841849/anounce_small', [300, 315], 'div-gpt-ad-1423826092090-3').addService(googletag.pubads());
            googletag.defineSlot('/51841849/anounce_small', [300, 315], 'div-gpt-ad-1423826092090-4').addService(googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>
</head>
<body class="body body__lite  body__bg2 body__homepage <?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?>  ">
<?php Yii::app()->ads->showCounters(); ?>
<div class="layout-container homepage">
    <div class="layout-loose layout-loose__white">
        <div class="layout-header">

            <!-- header-->
            <header class="header header__homepage">
                <div class="header_hold">
                    <div class="clearfix">
                        <div class="header-login"><a class="header-login_a login-button" data-bind="follow: {}">Вход</a><a class="header-login_a registration-button" data-bind="follow: {}">Регистрация</a></div>

                        <?php if ($this->module === null || $this->module->id != 'search'): ?>
                            <div class="sidebar-search clearfix sidebar-search__big">
                                <!-- <input type="text" name="" placeholder="Поиск" class="sidebar-search_itx"> -->
                                <!-- При начале ввода добавить класс .active на кнопку-->
                                <!-- <button class="sidebar-search_btn"></button> -->
                                <?php $this->widget('site.frontend.modules.search.widgets.YaSearchWidget'); ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="header_row-home">
                        <!-- logo-->
                        <h1 class="logo logo__l"><span class="logo_i">Веселый жираф - сайт для всей семьи</span></h1>
                        <!-- /logo-->
                    </div>
                </div>
            </header>
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

            <!-- Клубы-->
            <div class="homepage_row">
                <div class="homepage-clubs">
                    <div class="homepage_title"> Мы здесь общаемся<br>на различные семейные темы </div>
                    <div class="homepage-clubs_hold">
                        <!-- collection-->
                        <div class="homepage-clubs_collection homepage-clubs_collection__1">
                            <div class="homepage-clubs_title-hold">
                                <div class="homepage-clubs_title">Муж и жена</div>
                            </div>
                            <ul class="homepage-clubs_ul">
                                <li class="homepage-clubs_li"><a href="/wedding/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__14"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Свадьба</div></a></li>
                                <li class="homepage-clubs_li"><a href="/relations/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__15"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Отношение в семье </div></a></li>
                            </ul>
                        </div>
                        <!-- collection-->
                        <div class="homepage-clubs_collection homepage-clubs_collection__2">
                            <div class="homepage-clubs_title-hold">
                                <div class="homepage-clubs_title">Беременность и дети</div>
                            </div>
                            <ul class="homepage-clubs_ul">
                                <li class="homepage-clubs_li"><a href="/planning-pregnancy/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__1"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Планирование</div></a></li>
                                <li class="homepage-clubs_li"><a href="/pregnancy-and-birth/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__2"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Беременность и роды</div></a></li>
                                <li class="homepage-clubs_li"><a href="/babies/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__3"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Дети до года</div></a></li>
                                <li class="homepage-clubs_li"><a href="/kids/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__4"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Дети старше года</div></a></li>
                                <li class="homepage-clubs_li"><a href="/preschoolers/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__5"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Дошкольники</div></a></li>
                                <li class="homepage-clubs_li"><a href="/schoolers/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__6"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Школьники</div></a></li>
                            </ul>
                        </div>
                        <!-- collection-->
                        <div class="homepage-clubs_collection homepage-clubs_collection__3">
                            <div class="homepage-clubs_title-hold">
                                <div class="homepage-clubs_title">Наш дом</div>
                            </div>
                            <ul class="homepage-clubs_ul">
                                <li class="homepage-clubs_li"><a href="/cook/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__7"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Готовим на кухне</div></a></li>
                                <li class="homepage-clubs_li"><a href="/homework/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__9"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Домашние хлопоты</div></a></li>
                                <li class="homepage-clubs_li"><a href="/pets/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__11"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Наши питомцы</div></a></li>
                                <li class="homepage-clubs_li"><a href="/garden/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__10"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Сад и огород </div></a></li>
                                <li class="homepage-clubs_li"><a href="/repair-house/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__8"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Ремонт в доме</div></a></li>
                            </ul>
                        </div>
                        <!-- collection-->
                        <div class="homepage-clubs_collection homepage-clubs_collection__4">
                            <div class="homepage-clubs_title-hold">
                                <div class="homepage-clubs_title">Красота и здоровье</div>
                            </div>
                            <ul class="homepage-clubs_ul">
                                <li class="homepage-clubs_li"><a href="/beauty-and-fashion/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__12"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Красота и мода</div></a></li>
                                <li class="homepage-clubs_li"><a href="/health/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__13"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Наше здоровье</div></a></li>
                            </ul>
                        </div>
                        <!-- collection-->
                        <div class="homepage-clubs_collection homepage-clubs_collection__5">
                            <div class="homepage-clubs_title-hold">
                                <div class="homepage-clubs_title">Интересы и увлечения</div>
                            </div>
                            <ul class="homepage-clubs_ul">
                                <li class="homepage-clubs_li"><a href="/auto/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__18"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Наш автомобиль</div></a></li>
                                <li class="homepage-clubs_li"><a href="/needlework/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__16"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Рукоделие</div></a></li>
                                <li class="homepage-clubs_li"><a href="/homeflowers/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__17"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Цветы в доме</div></a></li>
                                <li class="homepage-clubs_li"><a href="/fishing/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__19"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Рыбалка</div></a></li>
                            </ul>
                        </div>
                        <!-- collection-->
                        <div class="homepage-clubs_collection homepage-clubs_collection__6">
                            <div class="homepage-clubs_title-hold">
                                <div class="homepage-clubs_title">Семейный отдых</div>
                            </div>
                            <ul class="homepage-clubs_ul">
                                <li class="homepage-clubs_li"><a href="/weekends/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__21"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Выходные с семьей</div></a></li>
                                <li class="homepage-clubs_li"><a href="/travel/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__20"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Мы путешествуем</div></a></li>
                                <li class="homepage-clubs_li"><a href="/holidays/" class="homepage-clubs_a">
                                        <div class="homepage-clubs_ico-hold">
                                            <div class="ico-club ico-club__22"></div>
                                        </div>
                                        <div class="homepage-clubs_tx">Семейные праздники</div></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="homepage-clubs_b">
                        <div class="homepage-clubs_btn-hold"><a class="homepage_btn-sign btn btn-xxl registration-button" data-bind="follow: {}">Начни общаться!</a></div>
                        <div class="homepage_desc-tx">узнавай новое, делись самым интересным </div>
                    </div>
                </div>
            </div>
            <!-- /Клубы-->


            <!-- Посты-->
            <div class="homepage_row">
                <div class="homepage-posts">
                    <div class="homepage_title"> Лучшие записи </div>
                    <div class="homepage-posts_col-hold">
                        <!-- anounce_big -->
                        <div id='div-gpt-ad-1423826092090-0' class="article-anonce article-anonce__xl">
                            <script type='text/javascript'>
                                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1423826092090-0'); });
                            </script>
                        </div>
                        <div id="div-gpt-ad-1423826092090-1" class="article-anonce article-anonce__ico">
                            <script type='text/javascript'>
                                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1423826092090-1'); });
                            </script>
                        </div>
                        <div id="div-gpt-ad-1423826092090-2" class="article-anonce">
                            <script type='text/javascript'>
                                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1423826092090-2'); });
                            </script>
                        </div>
                        <div id="div-gpt-ad-1423826092090-3" class="article-anonce">
                            <script type='text/javascript'>
                                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1423826092090-3'); });
                            </script>
                        </div>
                        <div id="div-gpt-ad-1423826092090-4" class="article-anonce">
                            <script type='text/javascript'>
                                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1423826092090-4'); });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Посты-->

            <!-- Посетители-->
            <?php $this->widget('application.widgets.home.CounterWidget'); ?>
            <!-- /Посетители-->

            <?php $this->renderPartial('//_footer'); ?>

        </div>
    </div>
</div>
<?php if (Yii::app()->user->isGuest): ?>
    <?php $this->widget('site.frontend.modules.signup.widgets.LayoutWidget'); ?>
<?php endif; ?>
</body>
</html>