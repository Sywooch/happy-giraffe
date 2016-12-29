<?php

Yii::app()->clientScript->registerAMD('headerSearch', ['common'], '
$("[href=#js-madal-search-box]").magnificPopup({
              type: "inline",
              preloader: false,
              closeOnBgClick: false,
              closeBtnInside: false,
              mainClass: "b-modal-search"
            });');

/** в случае нобходимости разбить стекло и раскомментировать
function activeClass($linkName)
{
    $action = \Yii::app()->controller->action->id;
    $class = 'header__li--active';

    switch ($linkName)
    {
        case 'pediatrician':
            return $action == 'pediatrician' ? $class : '';
        default:
            return;
    }
}
**/
?>
<div class="header__container">
    <div class="b-col b-col--1 b-fl">
        <a href="/" class="header__logo header__logo--style"></a><a href="#js-madal-search-box" class="header__search header__search--style"></a><a class="js-mobile-menu mobile-menu"><span></span></a>
    </div>
    <nav class="header__menu header__menu--style">
        <ul class="header__list">
            <li class="header__li"><a href="<?=$this->createUrl('/posts/forums/default/index')?>" class="header__link header__link--forum">Форумы</a></li>
            <li class="header__li header__li--active"><a href="<?=$this->createUrl('/som/qa/default/pediatrician')?>" class="header__link header__link--answer">Педиатр</a></li>
            <li class="header__li"><a href="<?=$this->createUrl('/posts/blogs/default/index')?>" class="header__link header__link--blog">Блоги</a></li>
            <li class="header__li"><a href="<?=$this->createUrl('/posts/buzz/list/index')?>" class="header__link header__link--life">Жизнь</a></li>
        </ul>
    </nav>
    <?php if (Yii::app()->user->isGuest): ?>
    <div class="header__unloged b-fr b-col b-col--2">
    	<span class="header__user header__user--style login-button" data-bind="follow: {}">
    		<span class="header-user__text">Войти</span>
    	</span>
    </div>
    <?php else: ?>
        <div class="header__loged b-fr b-col b-col--2">
        	<!-- <span class="header__signal header__signal--style"></span> -->
        	<a href="<?=$this->createUrl('/notifications/default/index')?>" class="header__signal header__signal--style" data-bind="css: { active: newNotificationsCount() > 0 && activeModule() != 'notifications' }"></a>
        	<span class="js-ava__link">
        		<a href="javascript:void(0)" class="ava ava--style ava--medium ava--medium_male">
        			<img src="<?=Yii::app()->user->model->getAvatarUrl(40)?>" class="ava__img">
        			<span class="ava__status ava__status--medium"></span>
                </a>
            </span>
        </div>
        <div class="user-widget-block user-widget-block_mod">
            <ul class="user-widget-block__list">
                <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_profile"><img src="<?=Yii::app()->user->model->getAvatarUrl(24)?>" class="user-widget-block__ava"/></span><span class="user-widget-block__text">Анкета</span></a></li>
                <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getFamilyUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_family"></span><span class="user-widget-block__text">Семья</span></a></li>
                <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getBlogUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_blog"></span><span class="user-widget-block__text">Блог</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/messaging/default/index')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_dialog"></span><span class="user-widget-block__text">Диалоги</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/friends/default/index')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_friend"></span><span class="user-widget-block__text">Друзья</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/photo/default/index', array('userId' => Yii::app()->user->id))?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_photo"></span><span class="user-widget-block__text">Фото</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/som/qa/my/questions')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_answers"></span><span class="user-widget-block__text">Ответы</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/users/default/settings')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_setting"></span><span class="user-widget-block__text">Настройки</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/site/logout')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_exit"></span><span class="user-widget-block__text">Выход</span></a></li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<div id="js-madal-search-box" class="madal-search-box mfp-hide">
    <div class="modal-search-block">
        <form class="modal-search-block__form" action="<?=$this->createUrl('/search/default/index')?>">
            <div class="modal-search-block__panel">
                <input type="hidden" name="searchid" value="1883818">
                <input type="hidden" name="web" value="0">
                <input type="text" name="text" placeholder="Поиск" class="modal-search-block__input">
                <button class="modal-search-block__btn"></button>
            </div>
        </form>
    </div>
</div>