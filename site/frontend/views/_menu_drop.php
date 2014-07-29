<?php
/* @var $cs ClientScript */
$cs = Yii::app()->clientScript;
if ($cs->useAMD)
    $cs->registerAMD('ko_menu', array('ko_menu'));
else
    Yii::app()->clientScript->registerPackage('ko_menu');
$user = Yii::app()->user->model;
?>

<!-- header-drop-->
<div class="header-drop">
    <div class="header-menu clearfix">
        <ul class="header-menu_ul">
            <li class="header-menu_li"><a href="<?=$user->getUrl()?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__profile"><span class="ava ava__small ava__<?=($user->gender == 0) ? 'female' : 'male'?>"><span class="ico-status ico-status__online"></span><?=CHtml::image($user->getAvatarUrl(24), '', array('class' => 'ava_img'))?></span></span><span class="header-menu_tx">Анкета</span></a></li>
            <li class="header-menu_li"><a href="<?=$user->getFamilyUrl()?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__family"></span><span class="header-menu_tx">Семья</span></a></li>
            <li class="header-menu_li"><a href="<?=$user->getBlogUrl()?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__blog"></span><span class="header-menu_tx">Блог</span></a></li>
            <li class="header-menu_li"><a href="<?=$user->getPhotosUrl()?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__photo"></span><span class="header-menu_tx">Фото</span></a></li>
            <li class="header-menu_li"><a href="<?=$this->createUrl('/favourites/default/index')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__favorite"></span><span class="header-menu_tx">Избранное</span></a></li>
            <li class="header-menu_li"><a href="/user/settings/" class="header-menu_a"><span class="header-menu_ico header-menu_ico__settings"></span><span class="header-menu_tx">Настройки</span></a></li>
            <li class="header-menu_li"><a href="<?=Yii::app()->createUrl('/site/logout')?>" class="header-menu_a"><span class="header-menu_ico header-menu_ico__logout"></span><span class="header-menu_tx"></span></a></li>
        </ul>
    </div>
    <!-- header-drop_b-->
    <div class="header-drop_b">
        <?php if ($user->clubSubscriptionsCount > 0): ?>
            <div class="float-r margin-t3"><a href="<?=$this->createUrl('/myGiraffe/default/recommends')?>">Жираф рекомендует</a></div>
            <div class="heading-small">Мои клубы <span class="color-gray"> (<?=$user->clubSubscriptionsCount?>)</span></div>
            <div class="club-list club-list__small clearfix">
                <ul class="club-list_ul clearfix">
                    <?php foreach ($user->clubSubscriptions as $cs): ?>
                        <?php if ($cs->club_id != 21 && $cs->club_id != 22): ?>
                            <li class="club-list_li">
                                <a href="<?=$cs->club->getUrl()?>" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/<?=$cs->club_id?>-w50.png" alt="" class="club-list_img"/></span></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="heading-small">Мои клубы <span class="color-gray">(0)</span> </div>
            <div class="header-drop_b-empty clearfix">
                <span class="color-gray padding-r5">Какие клубы выбрать?</span>
                <a href="<?=$this->createUrl('/myGiraffe/default/recommends')?>">Жираф рекомендует</a>
            </div>
        <?php endif; ?>
    </div>
    <!-- /header-drop_b-->
</div>
<!-- /header-drop-->