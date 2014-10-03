<?php
$user = Yii::app()->user->model;
?>

<!-- header-fix-->
<!-- ko stopBinding: true -->
<div class="header-fix">
    <div class="header-fix_hold clearfix"><a href="/" class="header-fix_logo"></a>
        <div class="header-fix_dropin" data-bind="css: { active : menuExtended }, click: function(data, event) {event.stopPropagation(); return true;}">
            <a class="header-fix_dropin-a" data-bind="click: function() {menuExtended(! menuExtended())}">
                    <span class="ava ava__middle ava__<?=($user->gender == 0) ? 'female' : 'male'?>">
                        <span class="ico-status ico-status__online"></span>
                        <?=CHtml::image($user->getAvatarUrl(40), '', array('class' => 'ava_img'))?>
                    </span>
                <span class="header_i-arrow"></span>
            </a>
            <?php $this->renderPartial('//_menu_drop'); ?>
        </div>
        <div class="header-fix-menu">
            <ul class="header-menu_ul clearfix">
                <!--<li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">прямой эфир</span></a></li>-->
                <li class="header-fix-menu_li active"><a href="<?=$this->createUrl('/myGiraffe/default/index', array('type' => 1))?>" class="header-fix-menu_a"><span class="header-fix-menu_tx">мой жираф</span><span class="header-fix-menu_count" data-bind="text: newPostsCount, visible: newPostsCount() > 0 && activeModule() != 'myGiraffe'"></span></a></li>
                <li class="header-fix-menu_li"><a href="<?=$this->createUrl('/messaging/default/index')?>" class="header-fix-menu_a"><span class="header-fix-menu_tx">диалоги</span><span class="header-fix-menu_count" data-bind="text: newMessagesCount, visible: newMessagesCount() > 0 && activeModule() != 'messaging'"></span></a></li>
                <li class="header-fix-menu_li"><a href="<?=$this->createUrl('/friends/default/index')?>" class="header-fix-menu_a"><span class="header-fix-menu_tx">друзья</span><span class="header-fix-menu_count" data-bind="text: newFriendsCount, visible: newFriendsCount() > 0 && activeModule() != 'friends'"></span></a></li>
                <li class="header-fix-menu_li"><a href="<?=$this->createUrl('/notifications/default/index')?>" class="header-fix-menu_a"><span class="header-fix-menu_tx">сигналы</span><span class="header-fix-menu_count" data-bind="text: newNotificationsCount, visible: newNotificationsCount() > 0 && activeModule() != 'notifications'"></span></a></li>
                <li class="header-fix-menu_li"><a href="<?=$this->createUrl('/scores/default/index')?>" class="header-fix-menu_a"><span class="header-fix-menu_tx">успехи</span><span class="header-fix-menu_count" data-bind="text: newScoreCount, visible: newScoreCount() > 0 && activeModule() != 'scores'"></span></a></li>
            </ul>
        </div>
    </div>
</div>
<!-- /ko -->
<!-- /header-fix-->