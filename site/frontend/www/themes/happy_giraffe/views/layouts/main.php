<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>
    <?php echo CHtml::metaTag('text/html; charset=utf-8', NULL, 'Content-Type'); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerCssFile('/stylesheets/global.css')
        ->registerCssFile('/stylesheets/common.css')
        ->registerCssFile('/stylesheets/ie.css', 'screen')
        ->registerCoreScript('jquery')
        ->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css')
        ->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.pack.js')
        ->registerScriptFile('/javascripts/jquery.iframe-post-form.js')
        ->registerScriptFile('/javascripts/jquery.placeholder.min.js')
        ->registerScriptFile('/javascripts/chosen.jquery.min.js')
        ->registerScriptFile('/javascripts/checkbox.js')
        ->registerScript('base_url', 'var base_url = \'' . Yii::app()->baseUrl . '\';', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/common.js')
    ;

    if (! Yii::app()->user->isGuest) {
        $cs
            ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
            ->registerScriptFile('/javascripts/comet.js')
            ->registerScriptFile('/javascripts/user_common.js')
            ->registerCssFile('/stylesheets/user_common.css')
            ->registerScriptFile('/javascripts/dklab_realplexor.js')
            ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . MessageCache::GetCurrentUserCache() . '\');')
        ;
    }

    if (!Yii::app()->user->isGuest)
        $user = User::getUserById(Yii::app()->user->getId());
    ?>
</head>
<body class="body-club">

    <div id="layout" class="wrapper">

        <div id="header-new" class="clearfix">

            <div class="top-line clearfix">

                <?php if (! Yii::app()->user->isGuest): ?>
                    <div class="user-nav">

                        <ul>
                            <li><a href=""><i class="icon icon-home"></i></a></li>
                            <li id="user-nav-messages">
                                <a href="/im/"><i class="icon icon-messages"></i><span class="count"></span></a>
                                <div class="drp">
                                    <div class="drp-title">Диалоги</div>
                                    <ul class="list">

                                    </ul>
                                    <div class="actions">
                                        <ul>
                                            <li><a href="<?php echo $this->createUrl('/im/') ?>">Все диалоги (<?php echo Im::model(Yii::app()->user->id)->getDialogsCount() ?>)</a></li>
                                            <li><a href="<?php echo $this->createUrl('/im/new') ?>">Новых</a> <a href="<?php echo $this->createUrl('/im/new') ?>" class="count"><?php echo count(MessageDialog::GetUserNewDialogs()) ?></a></li>
                                            <li><a href="<?php echo $this->createUrl('/im/online') ?>">Кто онлайн</a> <span><?php echo count(MessageDialog::GetUserOnlineDialogs()) ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li id="user-nav-friends">
                                <a href=""><i class="icon icon-friends"></i><span class="count">0</span></a>
                                <div class="drp drp-closable">
                                    <div class="drp-title">Друзья</div>
                                    <ul class="list"></ul>
                                    <div class="actions">
                                        <ul>
                                            <li><a href="">Все друзья (18)</a></li>
                                            <li><a href="">Кто онлайн</a> <span>8</span></li>
                                            <li><a href="">Предложения дружбы</a> <a href="" class="count count-gray">0</a></li>
                                            <li><a href="">Мои предложения</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li id="user-nav-notifications">
                                <a href=""><i class="icon icon-notifications"></i><span class="count">0</span></a>
                                <div class="drp drp-icons">
                                    <div class="drp-title">Уведомления</div>
                                    <ul class="list"></ul>
                                    <div class="actions">
                                        <ul>
                                            <li><a href="">Все уведомления (<span>0</span>)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="user">
                                <a href="<?php echo $this->createUrl('/user/profile', array('user_id'=>Yii::app()->user->getId())) ?>">
                                    <span class="ava small male"></span>
                                    <span class="username"><?php echo $user->first_name ?><i class="arr"></i></span>
                                </a>
                                <div class="drp">
                                    <div class="actions">
                                        <ul>
                                            <li><a href="<?php echo $this->createUrl('/user/profile', array('user_id'=>Yii::app()->user->getId())) ?>">Мой профайл<i class="icon icon-profile"></i></a></li>
                                            <li><a href="<?php echo $this->createUrl('/profile/index') ?>">Мои настройки<i class="icon icon-settings"></i></a></li>
                                            <li><a href="<?php echo $this->createUrl('/site/logout') ?>">Выйти<i class="icon icon-logout"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                <?php else: ?>
                    <?php $this->widget('application.widgets.loginWidget.LoginWidget'); ?>
                <?php endif; ?>

                <ul class="fast-links clearfix">
                    <li><a href="/">Главная</a></li>
                    <li><a href="<?php echo $this->createUrl('/community') ?>">Клубы</a></li>
                    <li><a href="">Сервисы</a></li>
                    <li><a href="">Конкурсы</a></li>
                </ul>

            </div>

            <div class="header-in">
                <div class="clearfix">

                    <div class="search-box clearfix">
                        <div class="input">
                            <input type="text" />
                        </div>
                        <button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
                    </div>

                    <div class="logo-box">
                        <a href="/" class="logo" title="hg.ru – Домашняя страница">Ключевые слова сайта</a>
                        <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
                    </div>

                    <div class="banner-box">
                        <a href=""><img src="/images/banner_01.png" />
                    </div>

                </div>

                <div class="nav">
                    <ul class="clearfix">
                        <li><a href=""><img src="/images/nav_tab_01.png" style="margin:-34px 0 -6px 0;" /></a></li>
                        <li><a href=""><img src="/images/nav_tab_02.png" /></a></li>
                        <li><a href=""><img src="/images/nav_tab_03.png" /></a></li>
                        <li><a href=""><img src="/images/nav_tab_04.png" /></a></li>
                        <li><a href=""><img src="/images/nav_tab_05.png" /></a></li>
                        <li><a href=""><img src="/images/nav_tab_06.png" /></a></li>
                        <li><a href=""><img src="/images/nav_tab_07.png" /></a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div id="content" class="clearfix">
            <?php echo $content; ?>
        </div>

        <div class="push"></div>

    </div>

    <div id="footer" class="wrapper clearfix">

        <div class="a-right">
            <a href="">Политика конфедециальности</a> &nbsp; | &nbsp; <a href="">Пользовательское соглашение</a>
        </div>

        <div class="copy">
            <p>Весёлый жираф &nbsp; © 2012 &nbsp; Все права защищены</p>
        </div>

    </div>

    <?php if (! Yii::app()->user->isGuest): ?>
        <script id="notificationTmpl" type="text/x-jquery-tmpl">
            <li><?php echo CHtml::link('{{html text}}<i class="icon icon-settings"></i>', '${url}') ;?></li>
        </script>

        <script id="friendNotificationTmpl" type="text/x-jquery-tmpl">
            <li><?php echo CHtml::link('{{html text}}<i class="close"></i>', '${url}') ;?></li>
        </script>

        <script id="imNotificationTmpl" type="text/x-jquery-tmpl">
            <li><?php echo CHtml::link('{{html text}}<i class="close"></i>', '${url}') ;?></li>
        </script>
    <?php endif; ?>

    <!-- Yandex.Metrika counter -->
    <div style="display:none;"><script type="text/javascript">
        (function(w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter11221648 = new Ya.Metrika({id:11221648, enableAll: true});
                }
                catch(e) { }
            });
        })(window, "yandex_metrika_callbacks");
    </script></div>
    <script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
    <noscript><div><img src="//mc.yandex.ru/watch/11221648" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <?php
    $sql_stats = YII::app()->db->getStats();
    echo $sql_stats[0] . ' запросов к БД, время выполнения запросов - ' . sprintf('%0.5f', $sql_stats[1]) . ' c.'; ?>

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-27545132-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
</body>
</html>
