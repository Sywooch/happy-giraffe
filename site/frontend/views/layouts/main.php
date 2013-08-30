<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?=$this->pageTitle?></title>
        <?php
        $r = time();
            Yii::app()->clientScript
                ->registerCssFile('/redactor/redactor.css')
                ->registerCssFile('/stylesheets/common.css')
                ->registerCssFile('/stylesheets/global.css')
                ->registerCssFile('/stylesheets/user.css')
                ->registerCssFile('/stylesheets/baby.css')
                ->registerCssFile('http://fonts.googleapis.com/css?family=Roboto:300&subset=latin,cyrillic-ext')

                ->registerCoreScript('jquery')
                ->registerCoreScript('yiiactiveform')
                ->registerPackage('ko_layout')
                ->registerPackage('ko_post')

                ->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css')
                ->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.js')
                ->registerScriptFile('/javascripts/chosen.jquery.min.js')
                ->registerScriptFile('/javascripts/jquery.powertip.js')
                ->registerScriptFile('/javascripts/common.js?'.$r)
                ->registerScriptFile('/javascripts/tooltipsy.min.js')
                ->registerScriptFile('/javascripts/addtocopy.js')
                ->registerScriptFile('/javascripts/jquery.placeholder.min.js')
            ;
        ?>

        <!--[if IE 7]>
            <link rel="stylesheet" href='/stylesheets/ie.css' type="text/css" media="screen" />
        <![endif]-->
    </head>
    <body class="body-gray">
        <div class="layout-container">
            <div class="layout-wrapper">
                <div class="layout-header clearfix">
                    <div class="layout-header_hold clearfix">

                        <h1 class="logo">
                            <?=HHtml::link('Веселый жираф - сайт для всей семьи', '/', array('class' => 'logo_i', 'title' => 'Веселый жираф - сайт для всей семьи'), true)?>
                            <strong class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</strong>
                        </h1>
                        <?php if (!Yii::app()->user->isGuest):?>
                            <!-- ko stopBinding: true -->
                            <div class="header-menu layout-binding">
                                <ul class="header-menu_ul clearfix">
                                    <li class="header-menu_li">
                                        <a href="" class="header-menu_a">
                                            <span class="header-menu_ico header-menu_ico__giraffe"></span>
                                            <span class="header-menu_tx">Мой <br> Жираф</span>
                                        </a>
                                    </li>
                                    <li class="header-menu_li" data-bind="css: { active : newNotificationsCount() > 0 }">
                                        <a href="<?=$this->createUrl('/notifications/default/index')?>" class="header-menu_a">
                                            <span class="header-menu_ico header-menu_ico__notice"></span>
                                            <span class="header-menu_tx">Мои <br> уведомления</span>
                                            <span class="header-menu_count" data-bind="text: newNotificationsCount"></span>
                                        </a>
                                    </li>
                                    <li class="header-menu_li">
                                        <a href="<?=$this->createUrl('/favourites/default/index')?>" class="header-menu_a">
                                            <span class="header-menu_ico header-menu_ico__favorite"></span>
                                            <span class="header-menu_tx">Мое <br> избранное</span>
                                        </a>
                                    </li>
                                    <li class="header-menu_li header-menu_li__sepor"></li>
                                    <li class="header-menu_li">
                                        <a href="<?=Yii::app()->user->model->url?>" class="header-menu_a">
                                            <span class="ava middle">
                                                <img src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" alt="">
                                            </span>
                                            <span class="header-menu_tx">Моя <br> страница</span>
                                        </a>
                                    </li>
                                    <li class="header-menu_li">
                                        <a href="" class="header-menu_a">
                                            <span class="header-menu_ico header-menu_ico__family"></span>
                                            <span class="header-menu_tx">Моя <br> семья</span>
                                        </a>
                                    </li>
                                    <li class="header-menu_li" data-bind="css: { active : newMessagesCount() > 0 }">
                                        <a href="<?=$this->createUrl('/messaging/default/index')?>" class="header-menu_a">
                                            <span class="header-menu_ico header-menu_ico__im"></span>
                                            <span class="header-menu_tx">Мои <br> сообщения</span>
                                            <span class="header-menu_count" data-bind="text: newMessagesCount"></span>
                                        </a>
                                    </li>
                                    <li class="header-menu_li" data-bind="css: { active : newFriendsCount() > 0 }">
                                        <a href="<?=$this->createUrl('/friends/default/index')?>" class="header-menu_a">
                                            <span class="header-menu_ico header-menu_ico__friend"></span>
                                            <span class="header-menu_tx">Мои <br> друзья</span>
                                            <span class="header-menu_count" data-bind="text: newFriendsCount"></span>
                                        </a>
                                    </li>
                                    <li class="header-menu_li">
                                        <a href="<?=$this->createUrl('/scores/default/index')?>" class="header-menu_a">
                                            <span class="header-menu_ico header-menu_ico__award"></span>
                                            <span class="header-menu_tx">Мои <br> успехи</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /ko -->
                            <a href="<?=Yii::app()->createUrl('/site/logout')?>" class="layout-header_logout">Выход</a>
                        <?php else: ?>

                        <?php endif ?>
                    </div>

                </div>

                <div class="layout-content clearfix">
                    <div class="content-cols clearfix">
                        <div class="col-1">
                            <div class="sidebar-search clearfix">
                                <form action="/search/">
                                    <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" name="query" id="site-search" onkeyup="SiteSearch.keyUp(this)">
                                    <input type="button" class="sidebar-search_btn" id="site-search-btn" onclick="return SiteSearch.click()"/>
                                </form>
                            </div>
                        </div>
                        <div class="col-23-middle">
                            <?php if (!Yii::app()->user->isGuest):?>
                                <?php if (isset($this->user) && $this->user->id == Yii::app()->user->id):?>
                                    <div class="user-add-record clearfix">
                                        <div class="user-add-record_ava-hold">
                                            <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel())); ?>
                                        </div>
                                        <div class="user-add-record_hold">
                                            <div class="user-add-record_tx">Я хочу добавить</div>
                                            <a href="<?=$this->createUrl('/blog/default/form', array('type' => 1))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
                                            <a href="<?=$this->createUrl('/blog/default/form', array('type' => 3))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
                                            <a href="<?=$this->createUrl('/blog/default/form', array('type' => 2))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy">Видео</a>
                                            <a href="<?=$this->createUrl('/blog/default/form', array('type' => 5))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy">Статус</a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="user-add-record user-add-record__small clearfix">
                                        <div class="user-add-record_ava-hold">
                                            <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 40)); ?>
                                        </div>
                                        <div class="user-add-record_hold">
                                            <div class="user-add-record_tx">Я хочу добавить</div>
                                            <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1)) ?>" data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy powertip" title="Статью"></a>
                                            <a href="<?= $this->createUrl('/blog/default/form', array('type' => 3)) ?>" data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy powertip" title="Фото"></a>
                                            <a href="<?= $this->createUrl('/blog/default/form', array('type' => 2)) ?>" data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy powertip" title="Видео"></a>
                                            <a href="<?= $this->createUrl('/blog/default/form', array('type' => 5)) ?>" data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy powertip" title="Статус"></a>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                    </div>

                    <?=$content?>
                </div>

                <a href="#layout" id="btn-up-page"></a>
                <div class="footer-push"></div>
            </div>
            <div class="layout-footer clearfix">
                <div class="layout-footer_hold">

                    <ul class="footer-list">
                        <li class="footer-list_li"><a href="" class="footer-list_a">Мобильная версия</a></li>
                        <li class="footer-list_li"><a href="" class="footer-list_a">О проекте</a></li>
                        <li class="footer-list_li"><a href="" class="footer-list_a">Правила</a></li>
                        <li class="footer-list_li"><a href="" class="footer-list_a">Задать вопрос</a></li>
                        <li class="footer-list_li"><a href="" class="footer-list_a">Реклама </a></li>
                        <li class="footer-list_li"><a href="" class="footer-list_a">Контакты </a></li>
                        <li class="footer-list_li"><a href="" class="footer-list_a">Партнер "Рамблера"</a></li>
                    </ul>
                    <ul class="footer-ul-bold">
                        <li class="footer-ul-bold_li"><a href="" class="footer-ul-bold_a">Беременность и дети</a></li>
                        <li class="footer-ul-bold_li"><a href="" class="footer-ul-bold_a">Наш дом</a></li>
                        <li class="footer-ul-bold_li"><a href="" class="footer-ul-bold_a">Красота и здоровье</a></li>
                        <li class="footer-ul-bold_li"><a href="" class="footer-ul-bold_a">Мужчина и женщина</a></li>
                        <li class="footer-ul-bold_li"><a href="" class="footer-ul-bold_a">Интересы и увлечения</a></li>
                        <li class="footer-ul-bold_li"><a href="" class="footer-ul-bold_a">Отдых</a></li>
                    </ul>

                    <div class="layout-footer_tx"> &copy; 2012-2013 Веселый Жираф. Социальная сеть для всей семьи. Использование редакционных материалов happy-giraffe.ru возможно только <br> с письменного разрешения редакции и/или при наличии активной ссылки на источник. Все права на пользовательские картинки и тексты принадлежат их авторам.
                        Сайт предназначен для лиц старше 16 лет.</div>
                </div>
            </div>
        </div>

        <div class="display-n">

        </div>

        <script type="text/javascript">
            var layoutVM = new LayoutViewModel();
            $(".layout-binding").each(function(index, el) {
                ko.applyBindings(layoutVM, el);
            });
        </script>
    </body>
</html>