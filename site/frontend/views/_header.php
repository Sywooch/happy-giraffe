<?php
/* @var $cs ClientScript */
$cs = Yii::app()->clientScript;

if ($cs->useAMD) {
    $cs->registerAMD('headerSearch', ['common'], '
$("[href=#js-madal-search-box]").magnificPopup({
              type: "inline",
              preloader: false,
              closeOnBgClick: false,
              closeBtnInside: false,
              mainClass: "b-modal-search"
            });');
//    $cs->registerAMD('headerMobileMenu', ['$' => 'jquery'], '$("body").on("click", function() {$("header .header__menu").removeClass("header__menu_open")})');
} else {
    $cs->registerScript('headerSearch', '$("[href=#js-madal-search-box]").magnificPopup({
              type: "inline",
              preloader: false,
              closeOnBgClick: false,
              closeBtnInside: false,
              mainClass: "b-modal-search"
            });');
//    $cs->registerScript('headerSearch', '$("body").on("click", function() {$("header .header__menu").removeClass("header__menu_open")})');
}

if (! Yii::app()->user->isGuest) {
    if ($cs->useAMD) {
        $cs->registerAMD('menuVM', array('ko' => 'knockout', 'MenuViewModel' => 'ko_menu'), "menuVm = new MenuViewModel(" . CJSON::encode($this->menuData) . "); ko.applyBindings(menuVm, $('.layout-header')[0]);");
    }
    else {
        $cs->registerPackage('ko_menu');
        ?><script type="text/javascript">
            menuVm = new MenuViewModel(<?=CJSON::encode($this->menuData)?>);
            ko.applyBindings(menuVm, $('.layout-header')[0]);
        </script><?php
    }
}
?>

<a class="mobile-menu"><span></span></a>
<a href="/" class="logo"></a><a class="header__search popup-a" href="#js-madal-search-box"></a>
<nav class="header__nav">
    <ul class="header__menu">
        <li class="header__li"><a href="<?=$this->createUrl('/posts/forums/default/index')?>" class="header__link header__link_comment">Форумы</a></li>
        <li class="header__li"><a href="<?=$this->createUrl('/som/qa/default/index')?>" class="header__link header__link_answers">Ответы</a></li>
        <li class="header__li"><a href="<?php echo $this->createUrl('/posts/blogs/default/index'); ?>" class="header__link header__link_blog">Блоги</a></li>
        <li class="header__li"><a href="<?=$this->createUrl('/posts/buzz/list/index')?>" class="header__link header__link_like">Жизнь</a></li>
        <li class="header__li"><a href="<?=$this->createUrl('/comments/contest/default/index')?>" class="header__link header__link_competition">Конкурс</a></li>
        <li class="header__li hidden-md"><a href="#js-madal-search-box" class="header__link header__link_search">Поиск</a></li>
    </ul>
    <?php if (Yii::app()->user->isGuest): ?>
        <div class="user-unloged">
            <span class="user-unloged__link login-button" data-bind="follow: {}">
                <span class="user-unloged__img"></span>
                <span class="user-unloged__text">ВОЙТИ</span>
            </span>
        </div>
    <?php else: ?>
        <div class="user-on"><a href="<?=$this->createUrl('/notifications/default/index')?>" class="signal active" data-bind="css: { active: newNotificationsCount() > 0 && activeModule() != 'notifications' }"></a>
            <div class="ava"><a class="js-ava__link ava__link" href="#" data-bind="click: function(data, event) {menuExtended(! menuExtended()); event.stopPropagation(); return true;}"><img src="<?=Yii::app()->user->model->getAvatarUrl(40)?>"></a></div>
        </div>
    <?php endif; ?>
</nav>

<?php if (! Yii::app()->user->isGuest): ?>
    <div class="user-widget-block user-widget-block_mod" data-bind="css: { 'user-widget-block_open': menuExtended() }, click: function(data, event) {event.stopPropagation(); return true;}">
        <ul class="user-widget-block__list">
            <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_profile"><img src="<?=Yii::app()->user->model->getAvatarUrl(24)?>" class="user-widget-block__ava"></span><span class="user-widget-block__text">Анкета</span></a></li>
            <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getFamilyUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_family"></span><span class="user-widget-block__text">Семья</span></a></li>
            <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getBlogUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_blog"></span><span class="user-widget-block__text">Блог</span></a></li>
            <li class="user-widget-block__li"><a href="<?=$this->createUrl('/messaging/default/index')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_dialog"></span><span class="user-widget-block__text">Диалоги</span></a></li>
            <li class="user-widget-block__li"><a href="<?=$this->createUrl('/friends/default/index')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_friend"></span><span class="user-widget-block__text">Друзья</span></a></li>
            <li class="user-widget-block__li"><a href="<?=$this->createUrl('/photo/default/index', array('userId' => Yii::app()->user->id))?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_photo"></span><span class="user-widget-block__text">Фото</span></a></li>
            <li class="user-widget-block__li"><a href="<?=$this->createUrl('/som/qa/my/questions')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_answers"></span><span class="user-widget-block__text">Вопросы</span></a></li>
            <li class="user-widget-block__li"><a href="<?=$this->createUrl('/users/default/settings')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_setting"></span><span class="user-widget-block__text">Настройки</span></a></li>
            <li class="user-widget-block__li"><a href="<?=$this->createUrl('/site/logout')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_exit"></span><span class="user-widget-block__text">Выход</span></a></li>
        </ul>
    </div>
<?php endif; ?>


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
