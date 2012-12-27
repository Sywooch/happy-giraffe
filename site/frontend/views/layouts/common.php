<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml" class="top-nav-fixed"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7 top-nav-fixed"> <![endif]-->
<!--[if gt IE 7]><!--> <html xmlns="http://www.w3.org/1999/xhtml" class="top-nav-fixed" xmlns:fb="http://ogp.me/ns/fb#"> <!--<![endif]-->
<head>
    <?=CHtml::linkTag()?>
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

    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/user.css')
        ->registerCssFile('/stylesheets/common.css')
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
        ->registerScriptFile('/javascripts/tooltipsy.min.js')
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
<body class="body-club<?php if ($this->broadcast): ?> body-broadcast<?php endif; ?>" onload="if (typeof(ODKL) !== 'undefined') ODKL.init();">
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
                <li class="item-ava tooltipsy-title" title="Моя анкета">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => Yii::app()->user->model,
                    'size' => 'small',
                    'small' => true,
                    'sendButton' => false,
                )); ?>
                </li>
                <li class="item-broadcast tooltipsy-title new" title="Что нового">
                    <a href="<?=$this->createUrl('/whatsNew/default/index')?>"><i class="icon-broadcast"></i></a>
                </li>
                <li class="item-dialogs tooltipsy-title<?php if ($imCount > 0): ?> new<?php endif; ?>" title="Мои диалоги">
                    <a href="javascript:void(0)" onclick="Messages.toggle()">
                        <i class="icon-dialogs"></i>
                        <div class="count"><span class="count-red"><?=$imCount?></span></div>
                    </a>
                </li>
                <li class="item-friends tooltipsy-title<?php if ($friendsCount > 0): ?> new<?php endif; ?>" title="Мои друзья">
                    <a href="javascript:void(0)" onclick="Friends.toggle()">
                        <i class="icon-friends"></i>
                        <div class="count"><span class="count-red"><?=$friendsCount?></span></div>
                    </a>
                </li>
                <li class="item-notifications tooltipsy-title<?php if ($notificationsCount > 0): ?> new<?php endif; ?>" title="Уведомления">
                    <a href="javascript:void(0)" onclick="Notifications.toggle()">
                        <i class="icon-notifications"></i>
                        <div class="count"><span class="count-red">+ <span><?=$notificationsCount?></span></span></div>
                    </a>
                </li>
                <li class="item-settings tooltipsy-title" title="Настройки">
                    <a href="javascript:void(0)" onclick="Settings.toggle()"><i class="icon-settings"></i></a>
                </li>
                <li class="item-logout tooltipsy-title" title="Выход">
                    <a href="<?php echo $this->createUrl('/site/logout') ?>"><i class="icon-logout"></i></a>
                </li>

            </ul>

        </div>
        <?php else: ?>
        <ul class="fast-links clearfix a-right">
            <li><?=CHtml::link('Вход', '#login', array('class' => 'fancy', 'rel' => 'nofollow', 'data-theme'=>'white-square')); ?></li>
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
    <?=$content ?>
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
        <p>Весёлый жираф &nbsp; © 2012 &nbsp; Все права защищены <img src="/images/icon-18+.png" alt="" class="icon-18"/><a href="<?=$this->createUrl('/site/moderationRules') ?>">Правила модерации</a></p>
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

        $(function() {
            $.post('/ajax/count/', {referrer:document.referrer});
        });
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
