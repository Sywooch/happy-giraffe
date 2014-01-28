<?php
Yii::app()->clientScript->registerPackage('ko_menu');
?>
<!-- ko stopBinding: true -->
<div class="layout-header clearfix">
    <!-- header-fix-->
    <div class="header-fix">
        <div class="header-fix_hold clearfix"><a href="" class="header-fix_logo"></a>
            <div class="header-fix_dropin"><a href="" class="header-fix_dropin-a"><span href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></span><span class="header_i-arrow"></span></a>
                <!-- header-drop-->
                <div class="header-drop">
                    <div class="header-menu clearfix">
                        <ul class="header-menu_ul">
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__profile"><span href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></span></span><span class="header-menu_tx">Анкета</span></a></li>
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__family"></span><span class="header-menu_tx">Семья</span></a></li>
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__blog"></span><span class="header-menu_tx">Блог</span></a></li>
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__photo"></span><span class="header-menu_tx">Фото</span></a></li>
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__favorite"></span><span class="header-menu_tx">Избранное</span></a></li>
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__settings"></span><span class="header-menu_tx">Настройки</span></a></li>
                            <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__logout"></span><span class="header-menu_tx"></span></a></li>
                        </ul>
                    </div>
                    <!-- header-drop_b-->
                    <div class="header-drop_b">
                        <div class="float-r margin-t3"><a href="">Жираф рекомендует</a></div>
                        <div class="heading-small">Мои клубы <span class="color-gray"> (5)</span></div>
                        <div class="club-list club-list__small clearfix">
                            <ul class="club-list_ul clearfix">
                                <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/2-w50.png" alt="" class="club-list_img"/></span></a></li>
                                <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/5-w50.png" alt="" class="club-list_img"/></span></a></li>
                                <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/7-w50.png" alt="" class="club-list_img"/></span></a></li>
                                <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/8-w50.png" alt="" class="club-list_img"/></span></a></li>
                                <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/9-w50.png" alt="" class="club-list_img"/></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /header-drop_b-->
                </div>
                <!-- /header-drop -->
            </div>
            <div class="header-fix-menu">
                <ul class="header-menu_ul clearfix">
                    <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">прямой эфир</span></a></li>
                    <li class="header-fix-menu_li active"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">мой жираф</span><span class="header-fix-menu_count">256</span></a></li>
                    <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">диалоги</span></a></li>
                    <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">друзья</span><span class="header-fix-menu_count">2</span></a></li>
                    <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">сигналы</span></a></li>
                    <li class="header-fix-menu_li"><a href="" class="header-fix-menu_a"><span class="header-fix-menu_tx">успехи</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /header-fix-->
    <!-- header-->
    <div class="header header__base">
        <div class="header_hold clearfix">
            <!-- logo-->
            <div class="logo"><a title="Веселый жираф - сайт для всей семьи" href="" class="logo_i">Веселый жираф - сайт для всей семьи</a><span class="logo_slogan">САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span></div>
            <!-- /logo-->
            <!-- header-menu-->
            <div class="header-menu">
                <ul class="header-menu_ul clearfix">
                    <!--<li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__broadcast"></span><span class="header-menu_tx">Прямой эфир</span></a></li>-->
                    <li class="header-menu_li" data-bind="css: { active : activeModule() == 'myGiraffe' }"><a href="<?=$this->createUrl('/myGiraffe/default/index', array('type' => 1))?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__giraffe"></span><span class="header-menu_tx">Мой Жираф</span><span class="header-menu_count" data-bind="text: newPostsCount, visible: newPostsCount() > 0"></span></a></li>
                    <li class="header-menu_li" data-bind="css: { active : activeModule() == 'messaging' }"><a href="<?=$this->createUrl('/messaging/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__im"></span><span class="header-menu_tx">Диалоги</span><span class="header-menu_count" data-bind="text: newMessagesCount, visible: newMessagesCount() > 0"></span></a></li>
                    <li class="header-menu_li" data-bind="css: { active : activeModule() == 'friends' }"><a href="<?=$this->createUrl('/friends/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__friend"></span><span class="header-menu_tx">Друзья</span><span class="header-menu_count" data-bind="text: newFriendsCount, visible: newFriendsCount() > 0"></span></a></li>
                    <li class="header-menu_li" data-bind="css: { active : activeModule() == 'notifications' }"><a href="<?=$this->createUrl('/notifications/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__notice"></span><span class="header-menu_tx">Сигналы</span><span class="header-menu_count" data-bind="text: newNotificationsCount, visible: newNotificationsCount() > 0"></span></a></li>
                    <li class="header-menu_li" data-bind="css: { active : activeModule() == 'scores' }"><a href="<?=$this->createUrl('/scores/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__award"></span><span class="header-menu_tx">Успехи</span><span class="header-menu_count" data-bind="text: newScoreCount, visible: newScoreCount() > 0"></span></a></li>
                    <li class="header-menu_li header-menu_li__dropin"><a href="" class="header-menu_a"><span href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></span><span class="header-menu_tx">Я<span class="header_i-arrow"></span></span></a>
                        <!-- header-drop-->
                        <div class="header-drop">
                            <div class="header-menu clearfix">
                                <ul class="header-menu_ul">
                                    <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__profile"><span href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></span></span><span class="header-menu_tx">Анкета</span></a></li>
                                    <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__family"></span><span class="header-menu_tx">Семья</span></a></li>
                                    <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__blog"></span><span class="header-menu_tx">Блог</span></a></li>
                                    <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__photo"></span><span class="header-menu_tx">Фото</span></a></li>
                                    <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__favorite"></span><span class="header-menu_tx">Избранное</span></a></li>
                                    <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__settings"></span><span class="header-menu_tx">Настройки</span></a></li>
                                    <li class="header-menu_li"><a href="" class="header-menu_a"><span class="header-menu_ico header-menu_ico__logout"></span><span class="header-menu_tx"></span></a></li>
                                </ul>
                            </div>
                            <!-- header-drop_b-->
                            <div class="header-drop_b">
                                <div class="float-r margin-t3"><a href="">Жираф рекомендует</a></div>
                                <div class="heading-small">Мои клубы <span class="color-gray"> (5)</span></div>
                                <div class="club-list club-list__small clearfix">
                                    <ul class="club-list_ul clearfix">
                                        <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/2-w50.png" alt="" class="club-list_img"/></span></a></li>
                                        <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/5-w50.png" alt="" class="club-list_img"/></span></a></li>
                                        <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/7-w50.png" alt="" class="club-list_img"/></span></a></li>
                                        <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/8-w50.png" alt="" class="club-list_img"/></span></a></li>
                                        <li class="club-list_li"><a href="" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/9-w50.png" alt="" class="club-list_img"/></span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /header-drop_b-->
                        </div>
                        <!-- /header-drop-->
                    </li>
                </ul>
            </div>
            <!-- /header-menu-->
        </div>
    </div>
    <!-- /header-->
</div>
<!-- /ko -->

<script type="text/javascript">
    ko.applyBindings(new MenuViewModel(<?=CJSON::encode($this->menuData)?>), $('.layout-header')[0]);
</script>