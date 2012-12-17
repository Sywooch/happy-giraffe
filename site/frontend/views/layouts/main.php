<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml" class="top-nav-fixed"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7 top-nav-fixed"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml" class="top-nav-fixed" xmlns:fb="http://ogp.me/ns/fb#"> <!--<![endif]-->
<head>
    <?php if ($this->rssFeed !== null): ?>
        <?=CHtml::linkTag('alternate', 'application/rss+xml', $this->rssFeed)?>
    <?php endif; ?>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
    <?=CHtml::metaTag('text/html; charset=utf-8', NULL, 'Content-Type')?>
    <?php if (!empty($this->meta_title)):?>
        <title><?=CHtml::encode(trim($this->meta_title))?></title>
    <?php else: ?>
        <title><?=CHtml::encode($this->pageTitle)?></title>
    <?php endif;

    $release_id = 133;
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/common.css')
        ->registerCssFile('/stylesheets/user.css')
        ->registerCssFile('/stylesheets/global.css')
        ->registerCssFile('/stylesheets/ie.css', 'screen')
        ->registerCssFile('/stylesheets/jquery.fancybox-1.3.4.css')

        ->registerCoreScript('jquery')
        ->registerCoreScript('yiiactiveform')
        ->registerCoreScript('bbq')

        ->registerScriptFile('/javascripts/jquery.fancybox-1.3.4.js')
        ->registerScriptFile('/javascripts/jquery.iframe-post-form.js')
        ->registerScriptFile('/javascripts/jquery.placeholder.min.js')
        ->registerScriptFile('/javascripts/chosen.jquery.min.js')
        ->registerScriptFile('/javascripts/checkbox.js')
        ->registerScript('base_url', 'var base_url = \'' . Yii::app()->baseUrl . '\';', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/common.js')
        ->registerScriptFile('/javascripts/base64.js')
        ->registerScriptFile('/javascripts/jquery.tooltip.pack.js')
        ->registerScriptFile('/javascripts/jquery.dataSelector.js')
        ->registerScriptFile('/javascripts/jquery.jcarousel.js')
        ->registerScriptFile('/javascripts/jquery.jcarousel.control.js')
        ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
        ->registerScriptFile('/javascripts/addtocopy.js')

        ->registerScriptFile('http://vk.com/js/api/share.js?11')
    ;

    $cs->registerMetaTag(trim($this->meta_description), 'description');
    if (!empty($this->meta_keywords))
        $cs->registerMetaTag(trim($this->meta_keywords), 'keywords');

    if (! Yii::app()->user->isGuest) {
        $cs
            ->registerPackage('comet')
            ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . UserCache::GetCurrentUserCache() . '\');')
            ->registerPackage('user')
            //->registerScript('im-urls', 'im.GetLastUrl="'.Yii::app()->createUrl('/im/default/getLast').';"')
        ;

        $interlocutor_id = Yii::app()->request->getQuery('im_interlocutor_id', 'null');
        $type = Yii::app()->request->getQuery('im_type', 'null');
        if ($interlocutor_id !== 'null' || $type !== 'null') {
            $cs->registerScript('openMessages', '$(function(){Messages.open(' . $interlocutor_id . ', ' . $type . ');});', CClientScript::POS_HEAD);
        }

        $openSettings = Yii::app()->request->getQuery('openSettings');
        if ($openSettings !== null)
            $cs->registerScript('openSettings', '$(function(){Settings.open(' . $openSettings . ');});', CClientScript::POS_HEAD);
    }

    if (!Yii::app()->user->isGuest)
        $user = Yii::app()->user->model;
    ?>
</head>
<body class="body-club<?php if ($this->module !== null && $this->module->id == 'whatsNew'): ?> body-broadcast<?php endif; ?>" onload="if (typeof(ODKL) !== 'undefined') ODKL.init();">

    <div class="top-line-menu">
        <div class="top-line-menu-holder">

            <?php if (! Yii::app()->user->isGuest): ?>
            <?php
            $notificationsCount = UserNotification::model()->getUserCount(Yii::app()->user->id);
            $friendsCount = FriendRequest::model()->getUserCount(Yii::app()->user->id);
            $imCount = Im::model()->getUnreadMessagesCount(Yii::app()->user->id);
            ?>
            <div class="user-nav-2">

                <ul>
                    <li class="item-ava tooltip" title="Моя анкета">
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => Yii::app()->user->model,
                            'size' => 'small',
                            'small' => true,
                            'sendButton' => false,
                        )); ?>
                    </li>
                    <li class="item-broadcast new">
                        <a href="<?=$this->createUrl('/whatsNew/default/index')?>"><i class="icon-broadcast"></i></a>
                    </li>
                    <li class="item-dialogs tooltip<?php if ($imCount > 0): ?> new<?php endif; ?>" title="Мои диалоги">
                        <a href="javascript:void(0)" onclick="Messages.toggle()">
                            <i class="icon-dialogs"></i>
                            <div class="count"><span class="count-red"><?=$imCount?></span></div>
                        </a>
                    </li>
                    <li class="item-friends tooltip<?php if ($friendsCount > 0): ?> new<?php endif; ?>" title="Мои друзья">
                        <a href="javascript:void(0)" onclick="Friends.toggle()">
                            <i class="icon-friends"></i>
                            <div class="count"><span class="count-red"><?=$friendsCount?></span></div>
                        </a>
                    </li>
                    <li class="item-notifications tooltip<?php if ($notificationsCount > 0): ?> new<?php endif; ?>" title="Уведомления">
                        <a href="javascript:void(0)" onclick="Notifications.toggle()">
                            <i class="icon-notifications"></i>
                            <div class="count"><span class="count-red">+ <span><?=$notificationsCount?></span></span></div>
                        </a>
                    </li>
                    <li class="item-settings tooltip" title="Настройки">
                        <a href="javascript:void(0)" onclick="Settings.toggle()"><i class="icon-settings"></i></a>
                    </li>
                    <li class="item-logout tooltip" title="Выход">
                        <a href="<?php echo $this->createUrl('/site/logout') ?>"><i class="icon-logout"></i></a>
                    </li>

                </ul>
                <?php if (false): ?>
                <ul>
                    <li><a href="<?php echo $this->createUrl('/user/profile', array('user_id'=>Yii::app()->user->id)) ?>"><i class="icon icon-home"></i></a></li>
                    <li id="user-nav-messages">
                        <a href="javascript:void(0)" onclick="Messages.toggle()"><i class="icon icon-messages"></i><span class="count"<?php if ($imCount == 0): ?> style="display: none;"<?php endif; ?>><?=$imCount?></span></a>
                    </li>
                    <li id="user-nav-friends">
                        <a href="javascript:void(0)" onclick="Friends.toggle()"><i class="icon icon-friends"></i><span class="count"<?php if ($friendsCount == 0): ?> style="display: none;"<?php endif; ?>><?=$friendsCount?></span></a>
                    </li>
                    <li id="user-nav-notifications">
                        <a href="javascript:void(0)" onclick="Notifications.toggle()"><i class="icon icon-notifications"></i><span class="count"<?php if ($notificationsCount == 0): ?> style="display: none;"<?php endif; ?>><?=$notificationsCount?></span></a>
                    </li>
                    <li>
                        <a href="<?=$this->createUrl('/scores/default/index') ?>"><i class="icon icon-points"></i><span class="count"><?= $user->score->scores ?></span></a>
                    </li>
                    <li class="item-ava">
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => Yii::app()->user->model, 'size' => 'small', 'small' => true, 'sendButton' => false)); ?>
                    </li>
                    <li id="user-nav-settings">
                        <a href="javascript:void(0)" onclick="Settings.toggle()"><i class="icon icon-settings"></i></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->createUrl('/site/logout') ?>"><i class="icon icon-logout"></i></a>
                    </li>
                </ul>
                <?php endif; ?>

            </div>
            <?php else: ?>
            <ul class="fast-links clearfix a-right">
                <li><?= CHtml::link('Вход', '#login', array('class' => 'fancy', 'rel' => 'nofollow', 'data-theme'=>'white-square')); ?></li>
                <li><?=CHtml::link('Регистрация', '#register', array('id'=>'reg-main-btn', 'class' => 'fancy', 'data-theme'=>'white-square'))?></li>
            </ul>
            <?php endif; ?>

            <ul class="fast-links clearfix">
                <li><a href="/">Главная</a></li>
                <li><a href="<?php echo $this->createUrl('/community') ?>">Клубы</a></li>
                <li><?=CHtml::link('Сервисы', array('/site/services'))?></li>
                <li><?=CHtml::link('Новости', array('/community/list', 'community_id' => 36))?></li>
                <li><?=CHtml::link('Конкурсы', $this->createUrl('/contest/default/index'))?></li>
            </ul>

        </div>
    </div>

<?php if (!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->checkAccess('editMeta')):?>
    <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
<?php endif ?>
    <div class="layout-container">
            <div id="layout" class="wrapper">

                <div id="header-new" class="<?php if (Yii::app()->user->isGuest): ?>guest <?php endif; ?>clearfix">

                    <div class="header-in">
                        <div class="clearfix">

                            <?php if (! Yii::app()->user->isGuest): ?>
                                <div class="search-box clearfix">
                                    <form action="<?php echo $this->createUrl('/search'); ?>">
                                        <div class="input">
                                            <input type="text" name="text" />
                                        </div>
                                        <button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
                                    </form>
                                </div>
                            <?php endif; ?>

                            <div class="logo-box">
                                <?=HHtml::link('', '/', array('class'=>'logo', 'title'=>'Веселый Жираф - сайт для всей семьи'), true)?>
                                <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
                            </div>

                            <div class="banner-box">
                                <?php if (! Yii::app()->user->isGuest): ?>
                                    <?php $contest_id = 5; ?>
                                    <a href="<?=$this->createUrl('/contest/default/view', array('id' => $contest_id)) ?>"><img src="/images/contest/banner-w300-<?=$contest_id?>.jpg" /></a>
                                <?php else: ?>
                                    <?=CHtml::link(CHtml::image('/images/banner_06.png'), '#register', array('class'=>'fancy', 'data-theme'=>'white-square'))?>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="nav">
                            <ul class="width-2 clearfix">
                                <?php if (false): ?>
                                    <li class="morning">
                                        <a href="<?=$this->createUrl('/morning/index') ?>"><i class="text"></i></a>
                                    </li>
                                <?php endif; ?>
                                <li class="kids navdrp">
                                    <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                                    <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                                    <div class="drp">
                                        <div class="in">

                                            <ul class="cols cols-5">
                                                <li class="col">

                                                    <div class="col-in bg-img-11">
                                                        <div class="title">Беременность и роды</div>
                                                        <ul>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 1))?>">Планирование</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 2))?>">Беременность</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 3))?>">Подготовка и роды</a></li>
                                                        </ul>
                                                    </div>

                                                </li>
                                                <li class="col">

                                                    <div class="col-in bg-img-12">
                                                        <div class="title">Дети до года</div>
                                                        <ul>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 4))?>">Здоровье</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 5))?>">Питание малыша</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 6))?>">Развитие ребенка</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 7))?>">Режим и уход</a></li>
                                                        </ul>
                                                    </div>

                                                </li>
                                                <li class="col">

                                                    <div class="col-in bg-img-13">
                                                        <div class="title">Дети старше года</div>
                                                        <ul>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 8))?>">Здоровье и питание</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 9))?>">Ясли и няни</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 10))?>">Раннее развитие и обучение</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 11))?>">Психология и воспитание</a></li>
                                                        </ul>
                                                    </div>

                                                </li>
                                                <li class="col">

                                                    <div class="col-in bg-img-14">
                                                        <div class="title">Дошкольники</div>
                                                        <ul>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 12))?>">Детский сад</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 13))?>">Готовимся к школе</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 14))?>">Игры и развлечения</a></li>
                                                        </ul>
                                                    </div>

                                                </li>
                                                <li class="col">

                                                    <div class="col-in bg-img-15">
                                                        <div class="title">Школьники</div>
                                                        <ul>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 15))?>">Здоровье и питание</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 16))?>">Учимся в школе</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 17))?>">Спорт и досуг</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 18))?>">Подростковая психология</a></li>
                                                        </ul>
                                                    </div>

                                                </li>

                                            </ul>

                                        </div>
                                    </div>
                                    <?php $this->endWidget();?>

                                </li>
                                <li class="manwoman navdrp">
                                    <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                                    <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                                    <div class="drp">
                                        <div class="in">

                                            <ul class="cols cols-2">
                                                <li class="col wedding">
                                                    <a class="big-link bg-img-21" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 32))?>">
                                                        <span class="title">Свадьба</span>
                                                        <span class="text">Всё об этом важном событии – от планов и составления списка гостей до проведения торжества.</span>
                                                    </a>
                                                </li>
                                                <li class="col relationships">
                                                    <div class="col-in bg-img-22">
                                                        <div class="title">Отношения</div>
                                                        <ul>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>239))?>">Отношения мужчины и женщины</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>242))?>">Непонимание в семье</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>243))?>">Ревность и измена</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>246))?>">Развод</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>248))?>">Психология мужчин</a></li>
                                                            <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 31, 'rubric_id'=>249))?>">Психология женщин</a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <?php $this->endWidget();?>

                                </li>
                                <li class="beauty navdrp">
                                    <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                                    <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                                    <div class="drp">
                                        <div class="in">

                                            <ul class="cols cols-3">
                                                <li class="col">
                                                    <a class="big-link bg-img-31" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 29))?>">
                                                        <span class="title">Красота</span>
                                                        <span class="text">Как сохранить красоту и продлить молодость - проверенные рецепты, советы экспертов и новые технологии.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-32" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 30))?>">
                                                        <span class="title">Мода и шоппинг</span>
                                                        <span class="text">Что нужно купить в этом сезоне? Где это продаётся? Есть ли скидки и акции? Для женщин, мужчин и детей – всё интересное о моде и покупках.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-33" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 33))?>">
                                                        <span class="title">Здоровье родителей</span>
                                                        <span class="text">Вся информация о заболеваниях, их лечении и профилактике, народные советы и адреса клиник.</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <?php $this->endWidget();?>

                                </li>
                                <li class="home navdrp">
                                    <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                                    <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                                    <div class="drp">
                                        <div class="in">

                                            <ul class="cols cols-5">
                                                <li class="col">
                                                    <a class="big-link bg-img-41" href="<?= Yii::app()->createUrl('/cook')?>">
                                                        <span class="title">Кулинарные рецепты</span>
                                                        <span class="text">Рецепты на все случаи жизни: простые и сложные, диетические и многие другие.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-42" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 23))?>">
                                                        <span class="title">Детские рецепты</span>
                                                        <span class="text">Готовим блюда, которые придутся по вкусу даже самому большому привереде.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-43" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 26))?>">
                                                        <span class="title">Интерьер и дизайн</span>
                                                        <span class="text">Советы о том, как превратить свое жилье в уютное гнездышко.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-44" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 28))?>">
                                                        <span class="title">Домашние хлопоты</span>
                                                        <span class="text">Превращаем самую тяжелую домашнюю работу в приятные хлопоты.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-45"  href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 34))?>">
                                                        <span class="title">Загородная жизнь</span>
                                                        <span class="text">Как рационально использовать загородный участок: посадки, строительство, отдых.</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <?php $this->endWidget();?>

                                </li>
                                <li class="hobbies navdrp">
                                    <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                                    <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                                    <div class="drp">
                                        <div class="in">

                                            <ul class="cols cols-4">
                                                <li class="col">
                                                    <a class="big-link bg-img-51" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 24))?>">
                                                        <span class="title">Своими руками</span>
                                                        <span class="text">Здесь всегда можно найти нужную информацию и поделиться своими идеями по  рукоделию и творчеству.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-52" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 25))?>">
                                                        <span class="title">Мастерим детям</span>
                                                        <span class="text">Мастер-классы и схемы по вязанию и шитью, для создания удивительных вещей вашими руками для детей.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-53" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 27))?>">
                                                        <span class="title">За рулем</span>
                                                        <span class="text">Здесь вы узнаете все тонкости покупки и содержания авто, а также оформления на него документов.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-54" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 35))?>">
                                                        <span class="title">Цветоводство</span>
                                                        <span class="text">Как выбрать комнатные цветы, куда поставить и что с ними делать – читайте в этом разделе.</span>
                                                    </a>
                                                </li>
                                            </ul>


                                        </div>
                                    </div>
                                    <?php $this->endWidget();?>

                                </li>
                                <li class="rest navdrp">
                                    <a href="javascript:void(0);" onclick="navDrpOpen(this);"><i class="text"></i></a>

                                    <?php $this->beginWidget('application.widgets.SeoContentWidget'); ?>
                                    <div class="drp">
                                        <div class="in">

                                            <ul class="cols cols-3">
                                                <li class="col">
                                                    <a class="big-link bg-img-61" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 19))?>">
                                                        <span class="title">Выходные с ребенком</span>
                                                        <span class="text">Информация о том, где происходят самые интересные события, которые можно посетить вместе с ребенком. Отзывы тех, кто там уже был.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-62" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 21))?>">
                                                        <span class="title">Путешествия семьей</span>
                                                        <span class="text">Планируем путешествие для всей семьи: выбираем маршрут, оформляем документы, едем, а потом делимся впечатлениями и фотографиями.</span>
                                                    </a>
                                                </li>
                                                <li class="col">
                                                    <a class="big-link bg-img-63" href="<?= Yii::app()->createUrl('/community/list', array('community_id' => 20))?>">
                                                        <span class="title">Праздники</span>
                                                        <span class="text">Как устроить потрясающий праздник для детей и взрослых. Как правильно выбирать подарки. Особенности религиозных праздников.</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <?php $this->endWidget();?>

                                </li>
                            </ul>
                        </div>

                    </div>

                </div>

                <div id="content" class="clearfix">
                    <?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links' => $this->breadcrumbs,
                            'separator' => ' &gt; ',
                            'htmlOptions' => array(
                                'id' => 'crumbs',
                                'class' => null,
                            ),
                        ));
                    ?>

                    <?php echo $content; ?>
                </div>

                <a href="#layout" id="btn-up-page"></a>
                <div class="push"></div>

            </div>

            <?php if (!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->checkAccess('commentator_panel')):?>
                <div id="commentator-link" style="position: fixed;top:70px;left: 0;z-index: 200;background:#42ff4c;">
                    <a target="_blank" href="<?=$this->createUrl('/signal/commentator/index') ?>" style="color: #333;font-weight:bold;">Панель для работы</a>
                </div>
            <?php endif ?>

            <div id="footer" class="wrapper clearfix">

                <div class="a-right">
                    <!--Отработало за <?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?> c -->
                    <!--<a>Политика конфиденциальности</a> &nbsp; | &nbsp; <a>Пользовательское соглашение</a> &nbsp; | &nbsp; -->
                </div>

                <div class="copy">
                    <p>Весёлый жираф &nbsp; © 2012 &nbsp; Все права защищены <img src="/images/icon-18+.png" alt="" class="icon-18"/></p>
                </div>

            </div>
    </div>

    <?php if (! Yii::app()->user->isGuest): ?>
        <script id="notificationTmpl" type="text/x-jquery-tmpl">
            <li><?php echo CHtml::link('{{html text}}<i class="icon icon-settings"></i>', '${url}') ;?></li>
        </script>

        <script id="friendNotificationTmpl" type="text/x-jquery-tmpl">
            <li id="${_id}"><?php echo CHtml::link('{{html text}}<i class="close"></i>', '${url}') ;?></li>
        </script>

        <script id="imNotificationTmpl" type="text/x-jquery-tmpl">
            <li><?php echo CHtml::link('{{html text}}', 'javascript:void(0)', array('onclick' => '${ok}')) ;?></li>
        </script>
    <?php endif; ?>

<?php if (Yii::app()->user->isGuest) {
    $this->widget('application.widgets.registerWidget.RegisterWidget');
    $this->widget('application.widgets.loginWidget.LoginWidget');
} ?>
    <noindex>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter11221648 = new Ya.Metrika({id:11221648, enableAll: true, trackHash:true, webvisor:true});
                    } catch(e) {}
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="//mc.yandex.ru/watch/11221648" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?=Yii::app()->params['gaCode']  ?>']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </noindex>
    <div id="body-overlay" style="display: none;"></div>

    <div class="popup-container">
        <div id="popup-preloader" style="display: none;">

            <div class="loading"><img src="/images/big_preloader.gif"></div>

        </div>
    </div>
</body>
</html>
