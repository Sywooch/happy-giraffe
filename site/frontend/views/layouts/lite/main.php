<!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->pageTitle?></title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
</head>
<body class="body body__bg1 body__lite">
<div class="layout-container">
    <div class="layout-loose layout-loose__white">
        <div class="layout-header">
            <!-- header-->
            <header class="header header__simple">
                <div class="header_hold clearfix">
                    <!-- logo-->
                    <div class="logo"><a title="Веселый жираф - сайт для всей семьи" href="<?=$this->createUrl('/site/index')?>" class="logo_i">Веселый жираф - сайт для всей семьи</a><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
                    <!-- /logo-->
                    <?php if ($this->module !== null && $this->module->id == 'search'): ?>
                        <div class="header-login"><a href="#loginWidget" class="header-login_a popup-a">Вход</a><a href="#registerWidget" class="header-login_a popup-a">Регистрация</a></div>
                        <?php $this->widget('site.frontend.modules.signup.widgets.LayoutWidget'); ?>
                    <?php endif; ?>
                    <!-- header-menu-->
                    <!--<div class="header-menu">
                        <ul class="header-menu_ul clearfix">
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__giraffe"></span><span class="header-menu_tx">Мой Жираф</span></a></li>
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__im"></span><span class="header-menu_tx">вам письмо</span></a></li>
                        </ul>
                    </div>-->
                    <!-- /header-menu-->
                    <?php if ($this->module->id != 'search'): ?>
                        <div class="sidebar-search clearfix sidebar-search__big">
                            <!-- <input type="text" name="" placeholder="Поиск" class="sidebar-search_itx"> -->
                            <!-- При начале ввода добавить класс .active на кнопку-->
                            <!-- <button class="sidebar-search_btn"></button> -->
                            <?php $this->widget('site.frontend.modules.search.widgets.YaSearchWidget'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </header>
            <!-- /header-->
        </div>
        <div class="layout-loose_hold clearfix">
            <!-- b-main -->
            <div class="b-main clearfix">
                <div class="b-main_cont">
                    <?php if ($this->breadcrumbs): ?>
                        <div class="b-crumbs b-crumbs__s">
                            <div class="b-crumbs_tx">Я здесь:</div>
                            <?php
                            $this->widget('zii.widgets.CBreadcrumbs', array(
                                'tagName' => 'ul',
                                'separator' => ' ',
                                'htmlOptions' => array('class' => 'b-crumbs_ul'),
                                'homeLink' => '<li class="b-crumbs_li"><a href="' . $this->createUrl('/site/index') . '" class="b-crumbs_a">Главная </a></li>',
                                'activeLinkTemplate' => '<li class="b-crumbs_li"><a href="{url}" class="b-crumbs_a">{label}</a></li>',
                                'inactiveLinkTemplate' => '<li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">{label}</span></li>',
                                'links' => $this->breadcrumbs,
                            ));
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?=$content?>
            </div>
            <!-- b-main -->
            <!-- layout-footer-->
            <div class="layout-footer clearfix">
                <div class="layout-footer_hold">
                    <ul class="footer-list">
                        <li class="footer-list_li visible-md-inline-block"><span class="footer-list_a">О нас</span></li>
                        <li class="footer-list_li"><span class="footer-list_a">Правила сайта</span></li>
                        <li class="footer-list_li"><a href="<?=$this->createUrl('/site/page', array('view' => 'abuse'))?>" class="footer-list_a">Правообладателям</a></li>
                        <li class="footer-list_li"><a href="<?=$this->createUrl('/site/page', array('view' => 'advertiser'))?>" class="footer-list_a footer-list__reklama">Реклама </a></li>
                        <li class="footer-list_li"><span class="footer-list_a">Контакты </span></li>
                        <li class="footer-list_li footer-list_li__rambler visible-md-inline-block"><a href="http://www.rambler.ru" class="footer-list_a">Партнер "Рамблера"</a><span id="counter-rambler" class="footer-list_rambler-count"></span></li>
                    </ul>
                    <ul class="footer-menu visible-md">
                        <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 1))?>" class="footer-menu_a footer-menu_a__pregnancy">Беременность и дети</a></li>
                        <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 2))?>" class="footer-menu_a footer-menu_a__home">Наш дом</a></li>
                        <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 3))?>" class="footer-menu_a footer-menu_a__beauty">Красота и здоровье</a></li>
                        <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 4))?>" class="footer-menu_a footer-menu_a__husband-and-wife">Мужчина и женщина</a></li>
                        <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 5))?>" class="footer-menu_a footer-menu_a__hobby">Интересы и увлечения</a></li>
                        <li class="footer-menu_li"><a href="<?=$this->createUrl('/community/default/section', array('section_id' => 6))?>" class="footer-menu_a footer-menu_a__family-holiday">Отдых</a></li>
                    </ul>
                    <div class="layout-footer_tx">© 2012–2014 Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские картинки и тексты принадлежат их авторам. Сайт предназначен для лиц старше 16 лет.</div>
                    <div class="layout-footer_privacy-hold"><span class="layout-footer_privacy">Политика конфедициальности</span></div>
                </div>
            </div>
            <!-- /layout-footer-->
        </div>
        <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
    </div>
</div>
<div class="popup-container display-n">
</div>
<!--[if lt IE 9]> <script type="text/javascript" src="/lite/javascript/respond.min.js"></script> <![endif]-->
<script type="text/javascript">
    require(['lite']);
</script>
<?php Yii::app()->ads->showCounters(); ?>
</body></html>