<?php
$user = Yii::app()->user->model;
?>

<!-- header-->
<!-- ko stopBinding: true -->
<div class="header header__user header__base">
    <div class="header_hold clearfix">
        <!-- logo-->
        <div class="logo"><?=HHtml::link('Веселый жираф - сайт для всей семьи', '/', array('class' => 'logo_i', 'title' => 'Веселый жираф - сайт для всей семьи'), true)?><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
        <!-- /logo-->
        <!-- header-menu-->
        <div class="header-menu">
            <ul class="header-menu_ul clearfix">
                <li class="header-menu_li"><a href="<?=$this->createUrl('/blog/air/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__broadcast"></span><span class="header-menu_tx">Прямой эфир</span></a></li>
                <li class="header-menu_li" data-bind="css: { active : activeModule() == 'myGiraffe' }"><a href="<?=$this->createUrl('/myGiraffe/default/index', array('type' => 1))?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__giraffe"></span><span class="header-menu_tx">Мой Жираф</span><span style='display:none;' class="header-menu_count" data-bind="text: newPostsCount, visible: newPostsCount() > 0 && activeModule() != 'myGiraffe'"></span></a></li>
                <li class="header-menu_li" data-bind="css: { active : activeModule() == 'messaging' }"><a href="<?=$this->createUrl('/messaging/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__im"></span><span class="header-menu_tx">Диалоги</span><span class="header-menu_count" style='display:none;' data-bind="text: newMessagesCount, visible: newMessagesCount() > 0 && activeModule() != 'messaging'"></span></a></li>
                <li class="header-menu_li" data-bind="css: { active : activeModule() == 'friends' }"><a href="<?=$this->createUrl('/friends/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__friend"></span><span class="header-menu_tx">Друзья</span><span class="header-menu_count" style='display:none;' data-bind="text: newFriendsCount, visible: newFriendsCount() > 0 && activeModule() != 'friends'"></span></a></li>
                <li class="header-menu_li" data-bind="css: { active : activeModule() == 'notifications' }"><a href="<?=$this->createUrl('/notifications/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__notice"></span><span class="header-menu_tx">Сигналы</span><span class="header-menu_count" style='display:none;' data-bind="text: newNotificationsCount, visible: newNotificationsCount() > 0 && activeModule() != 'notifications'"></span></a></li>
                <li class="header-menu_li" data-bind="css: { active : activeModule() == 'scores' }"><a href="<?=$this->createUrl('/scores/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__award"></span><span class="header-menu_tx">Успехи</span><span class="header-menu_count" style='display:none;' data-bind="text: newScoreCount, visible: newScoreCount() > 0 && activeModule() != 'scores'"></span></a></li>
                <li class="header-menu_li header-menu_li__dropin" data-bind="css: { active : menuExtended }, click: function(data, event) {event.stopPropagation(); return true;}">
                    <a class="header-menu_a" data-bind="click: function() {menuExtended(! menuExtended())}">
                            <span class="ava ava__middle ava__<?=($user->gender == 0) ? 'female' : 'male'?>">
                                <span class="ico-status ico-status__online"></span>
                                <?=CHtml::image($user->getAvatarUrl(40), '', array('class' => 'ava_img'))?>
                            </span>
                        <span class="header-menu_tx">Я<span class="header_i-arrow"></span></span>
                    </a>
                    <?php $this->renderPartial('//_menu_drop'); ?>
                </li>
            </ul>
        </div>
        <!-- /header-menu-->
    </div>
</div>
<!-- /ko -->
<!-- /header-->