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
