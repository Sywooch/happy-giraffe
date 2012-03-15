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
            ->registerScriptFile('/javascripts/im.js')
            ->registerScript('im-urls', 'im.GetLastUrl="'.Yii::app()->createUrl('/im/default/getLast').'"')
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
                                    <!--<div class="actions">
                                        <ul>
                                            <li><a href="">Все уведомления (<span>0</span>)</a></li>
                                        </ul>
                                    </div>-->
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
                        <form action="<?php echo $this->createUrl('site/search'); ?>">
                            <div class="input">
                                <input type="text" name="text" />
                            </div>
                            <button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
                        </form>
                    </div>

                    <div class="logo-box">
                        <a href="/" class="logo" title="hg.ru – Домашняя страница">Ключевые слова сайта</a>
                        <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
                    </div>

                    <div class="banner-box">
                        <a href=""><img src="/images/banner_01.png" /></a>
                    </div>

                </div>

                <div class="nav">
                <ul class="clearfix">
                <li class="morning">
                    <a href=""><i class="text"></i></a>
                </li>
                <li class="kids">
                    <a href=""><i class="text"></i></a>

                    <div class="drp">
                        <div class="in">

                            <ul class="cols cols-5">
                                <li class="col">

                                    <div class="col-in">
                                        <div class="title">Беременность и роды</div>
                                        <ul>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 1))?>">Планирование</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 2))?>">Беременность</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 3))?>">Подготовка и роды</a></li>
                                        </ul>
                                        <span class="img"><img src="/images/nav_kids_img_01.jpg"></span>
                                    </div>

                                </li>
                                <li class="col">

                                    <div class="col-in">
                                        <div class="title">Дети до года</div>
                                        <ul>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 4))?>">Здоровье</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 5))?>">Питание малыша</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 6))?>">Развитие ребенка</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 7))?>">Режим и уход</a></li>
                                        </ul>
                                        <span class="img"><img src="/images/nav_kids_img_02.jpg"></span>
                                    </div>

                                </li>
                                <li class="col">

                                    <div class="col-in">
                                        <div class="title">Дети старше года</div>
                                        <ul>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 8))?>">Здоровье и питание</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 9))?>">Ясли и няни</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 10))?>">Раннее развитие и обучение</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 11))?>">Психология и воспитание</a></li>
                                        </ul>
                                        <span class="img"><img src="/images/nav_kids_img_03.jpg"></span>
                                    </div>

                                </li>
                                <li class="col">

                                    <div class="col-in">
                                        <div class="title">Дошкольники</div>
                                        <ul>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 12))?>">Детский сад</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 13))?>">Игры и развлечения</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 14))?>">Готовимся к школе</a></li>
                                        </ul>
                                        <span class="img"><img src="/images/nav_kids_img_04.jpg"></span>
                                    </div>

                                </li>
                                <li class="col">

                                    <div class="col-in">
                                        <div class="title">Школьники</div>
                                        <ul>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 15))?>">Здоровье и питание</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 16))?>">Учимся в школе</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 17))?>">Спорт и досуг</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 18))?>">Подростковая психология</a></li>
                                        </ul>
                                        <span class="img"><img src="/images/nav_kids_img_05.jpg"></span>
                                    </div>

                                </li>

                            </ul>

                        </div>
                    </div>
                </li>
                <li class="manwoman">
                    <a href=""><i class="text"></i></a>

                    <div class="drp">
                        <div class="in">

                            <ul class="cols cols-2">
                                <li class="col wedding">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 32))?>">
                                        <span class="title">Свадьба</span>
                                        <span class="text">Всё об этом важном событии – от планов и составления списка гостей до проведения торжества.</span>
                                        <span class="img"><img src="/images/nav_manwoman_img_01.jpg"></span>
                                    </a>
                                </li>
                                <li class="col relationships">
                                    <div class="col-in">
                                        <div class="title">Отношения</div>
                                        <ul>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 31, 'rubric_id'=>239))?>">Отношения мужчины и женщины</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 31, 'rubric_id'=>242))?>">Непонимание в семье</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 31, 'rubric_id'=>243))?>">Ревность и измена</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 31, 'rubric_id'=>246))?>">Развод</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 31, 'rubric_id'=>248))?>">Психология мужчин</a></li>
                                            <li><a href="<?= Yii::app()->createUrl('community/list', array('community_id' => 31, 'rubric_id'=>249))?>">Психология женщин</a></li>
                                        </ul>
                                        <span class="img"><img src="/images/nav_manwoman_img_02.jpg"></span>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </li>
                <li class="beauty">
                    <a href=""><i class="text"></i></a>

                    <div class="drp">
                        <div class="in">

                            <ul class="cols cols-3">
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 29))?>">
                                        <span class="title">Красота</span>
                                        <span class="text">Как сохранить красоту и продлить молодость - проверенные рецепты, советы экспертов и новые технологии.</span>
                                        <span class="img"><img src="/images/nav_beauty_img_01.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 30))?>">
                                        <span class="title">Мода и шоппинг</span>
                                        <span class="text">Что нужно купить в этом сезоне? Где это продаётся? Есть ли скидки и акции? Для женщин, мужчин и детей – всё интересное о моде и покупках.</span>
                                        <span class="img"><img src="/images/nav_beauty_img_02.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 33))?>">
                                        <span class="title">Здоровье родителей</span>
                                        <span class="text">Вся информация о заболеваниях, их лечении и профилактике, народные советы и адреса клиник.</span>
                                        <span class="img"><img src="/images/nav_beauty_img_03.jpg"></span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </li>
                <li class="home">
                    <a href=""><i class="text"></i></a>

                    <div class="drp">
                        <div class="in">

                            <ul class="cols cols-5">
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 22))?>">
                                        <span class="title">Кулинарные рецепты</span>
                                        <span class="text">Рецепты на все случаи жизни: простые и сложные, диетические и многие другие.</span>
                                        <span class="img"><img src="/images/nav_home_img_01.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 23))?>">
                                        <span class="title">Детские рецепты</span>
                                        <span class="text">Готовим блюда, которые придутся по вкусу даже самому большому привереде.</span>
                                        <span class="img"><img src="/images/nav_home_img_02.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 26))?>">
                                        <span class="title">Интерьер и дизайн</span>
                                        <span class="text">Советы о том, как превратить свое жилье в уютное гнездышко.</span>
                                        <span class="img"><img src="/images/nav_home_img_03.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 28))?>">
                                        <span class="title">Домашние хлопоты</span>
                                        <span class="text">Превращаем самую тяжелую домашнюю работу в приятные хлопоты.</span>
                                        <span class="img"><img src="/images/nav_home_img_04.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 34))?>">
                                        <span class="title">Загородная жизнь</span>
                                        <span class="text">Как рационально использовать загородный участок: посадки, строительство, отдых.</span>
                                        <span class="img"><img src="/images/nav_home_img_05.jpg"></span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </li>
                <li class="hobbies">
                    <a href=""><i class="text"></i></a>

                    <div class="drp">
                        <div class="in">

                            <ul class="cols cols-4">
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 24))?>">
                                        <span class="title">Своими руками</span>
                                        <span class="text">Здесь всегда можно найти нужную информацию и поделиться своими идеями по  рукоделию и творчеству.</span>
                                        <span class="img"><img src="/images/nav_hobbies_img_01.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 25))?>">
                                        <span class="title">Мастерим детям</span>
                                        <span class="text">Мастер-классы и схемы по вязанию и шитью, для создания удивительных вещей вашими руками для детей.</span>
                                        <span class="img"><img src="/images/nav_hobbies_img_02.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 27))?>">
                                        <span class="title">За рулем</span>
                                        <span class="text">Здесь вы узнаете все тонкости покупки и содержания авто, а также оформления на него документов.</span>
                                        <span class="img"><img src="/images/nav_hobbies_img_03.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 35))?>">
                                        <span class="title">Цветоводство</span>
                                        <span class="text">Как выбрать комнатные цветы, куда поставить и что с ними делать – читайте в этом разделе.</span>
                                        <span class="img"><img src="/images/nav_hobbies_img_04.jpg"></span>
                                    </a>
                                </li>
                            </ul>


                        </div>
                    </div>
                </li>
                <li class="rest">
                    <a href=""><i class="text"></i></a>

                    <div class="drp">
                        <div class="in">

                            <ul class="cols cols-3">
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 19))?>">
                                        <span class="title">Выходные с ребенком</span>
                                        <span class="text">Информация о том, где происходят самые интересные события, которые можно посетить вместе с ребенком. Отзывы тех, кто там уже был.</span>
                                        <span class="img"><img src="/images/nav_rest_img_01.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 21))?>">
                                        <span class="title">Путешествия семьей</span>
                                        <span class="text">Планируем путешествие для всей семьи: выбираем маршрут, оформляем документы, едем, а потом делимся впечатлениями и фотографиями.</span>
                                        <span class="img"><img src="/images/nav_rest_img_02.jpg"></span>
                                    </a>
                                </li>
                                <li class="col">
                                    <a class="big-link" href="<?= Yii::app()->createUrl('community/list', array('community_id' => 20))?>">
                                        <span class="title">Праздники</span>
                                        <span class="text">Как устроить потрясающий праздник для детей и взрослых. Как правильно выбирать подарки. Особенности религиозных праздников.</span>
                                        <span class="img"><img src="/images/nav_rest_img_03.jpg"></span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </li>
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
            <li><?php echo CHtml::link('{{html text}}', '${url}') ;?></li>
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
