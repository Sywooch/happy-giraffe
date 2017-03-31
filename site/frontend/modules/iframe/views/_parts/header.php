<?php
use site\frontend\modules\iframe\components\QaRatingManager;
use site\frontend\modules\iframe\modules\notifications\models\Notification;

$rating = (new QaRatingManager())->getViewCounters(Yii::app()->user->id);
$countNotification = Notification::getUnreadCount();


$cs = Yii::app()->clientScript;

$cs->registerAMD('headerSearch', ['common'], '
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

if (! Yii::app()->user->isGuest) {
    if ($cs->useAMD) {
        $cs->registerAMD('menuVM', array('ko' => 'knockout', 'MenuViewModel' => 'ko_menu'), "menuVm = new MenuViewModel(" . CJSON::encode($this->menuData) . "); ko.applyBindings(menuVm, $('.layout-header')[0]);");
    }
    else {
        $cs->registerPackage('ko_menu');
        ?>
        <script type="text/javascript">
            menuVm = new MenuViewModel(<?=CJSON::encode($this->menuData)?>);
            ko.applyBindings(menuVm, $('.layout-header')[0]);
        </script>
        <?php
    }
}
?>
<div class="header__container">
    <div class="b-col b-col--1 b-fl">
        <a href="<?=$this->createUrl('/iframe/default/pediatrician')?>" class="header__logo header__logo--style header-iframe__logo"></a>
        <a class="js-mobile-menu mobile-menu"><span></span></a>
    </div>
    <nav class="header__menu header__menu--style header-iframe__menu--style">
        <ul class="header__list">
            <li class="header__li <?=$this->action->id=='pediatricianList'?'':'header-iframe__li--active';?>"><a href="<?=$this->createUrl('/iframe/default/pediatrician')?>" class="header__link header-iframe__link header__link--answer">Вопросы</a></li>
            <li class="header__li <?=$this->action->id=='pediatricianList'?'header-iframe__li--active':'';?>"><a href="<?=$this->createUrl('/iframe/default/pediatricianList')?>" class="header__link header-iframe__link header__link--doc">Врачи</a></li>
        </ul>
    </nav>
    <?php if (Yii::app()->user->isGuest): ?>
    <div class="header__unloged b-fr b-col b-col--2">
    	<span class="header__user header__user--style login-button" data-bind="follow: {}">
    		<span class="header-user__text">Войти</span>
    	</span>
    </div>
    <?php else: ?>
        <div class="header__loged b-fr b-col header-iframe_loged">
        	<!-- <span class="header__signal header__signal--style"></span> -->
            <?php $this->renderPartial('application.modules.iframe.views._sidebar.new_ask');?>
        	<span class="js-ava__link">
        		<a href="javascript:void(0)" class="ava ava--style ava--medium ava--medium_male">
        			<img src="<?=Yii::app()->user->model->getAvatarUrl(40)?>" class="ava__img">
        			<span class="ava__status ava__status--medium"></span>
                </a>
            </span>
        </div>
        <div class="user-widget-block user-widget-block-iframe user-widget-block_mod">
            <ul class="user-widget-block-iframe__list">
                <li class="user-widget-block-iframe__li">
                    <a class="user-widget-block-iframe__link" href="<?=$this->createUrl('/iframe/notifications/default/index')?>"><span class="user-widget-block-iframe__icon user-widget-block-iframe__icon-signal"></span>Сигналы</a>
                    <span class="user-widget-block-iframe__notific"><?=$countNotification?></span>
                </li>
<!--                <li class="user-widget-block-iframe__li user-widget-block-iframe__li-disabled">-->
<!--                    <a class="user-widget-block-iframe__link" href="#"><span class="user-widget-block-iframe__icon user-widget-block-iframe__icon-kids"></span>Дети</a>-->
<!--                    <a class="user-widget-block-iframe__add-child" href="#">Добавить</a>-->
<!--                </li>-->
                <li class="user-widget-block-iframe__li <?=$rating['questions']?'':'user-widget-block-iframe__li-disabled'?>">
                    <?php if($rating['questions']){ ?>
                        <a class="user-widget-block-iframe__link" href="<?=$this->createUrl('/iframe/my/questions')?>"><span class="user-widget-block-iframe__icon user-widget-block-iframe__icon-question"></span>Мои вопросы</a>
                    <?php } else {?>
                        <span class="user-widget-block-iframe__link"><span class="user-widget-block-iframe__icon user-widget-block-iframe__icon-question"></span>Мои вопросы</span>
                    <?php } ?>
                    <span class="user-widget-block-iframe__count"><?=$rating['questions']?></span>
                </li>
                <li class="user-widget-block-iframe__li <?=$rating['rating']['answers_count']?'':'user-widget-block-iframe__li-disabled'?>">
                    <?php if($rating['rating']['answers_count']){ ?>
                        <a class="user-widget-block-iframe__link" href="<?=$this->createUrl('/iframe/my/answers')?>"><span class="user-widget-block-iframe__icon user-widget-block-iframe__icon-comment"></span>Мои ответы</a>
                    <?php } else {?>
                        <span class="user-widget-block-iframe__link"><span class="user-widget-block-iframe__icon user-widget-block-iframe__icon-comment"></span>Мои ответы</span>
                    <?php } ?>
                    <span class="user-widget-block-iframe__count"><?=$rating['rating']['answers_count']?></span>
                </li>
                <li class="user-widget-block-iframe__li">
                    <a class="user-widget-block-iframe__link" href="<?=$this->createUrl('/site/logout')?>"><span class="user-widget-block-iframe__icon user-widget-block-iframe__icon-exit"></span>Выход</a>
                </li>
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