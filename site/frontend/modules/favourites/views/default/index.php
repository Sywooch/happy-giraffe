<?php
Yii::app()->clientScript->registerPackage('ko_favourites');
$this->widget('FavouriteWidget', array('registerScripts' => true));
Yii::app()->clientScript->registerPackage('ko_comments');
?>

<div class="content-cols clearfix">
    <div class="col-1">
        <?php $this->widget('Avatar', array('user' => Yii::app()->user->model, 'size' => 200, 'location' => true, 'age' => true)); ?>

        <div class="menu-list menu-list__favorites">
            <a class="menu-list_i menu-list_i__all" data-bind="css : { active : activeMenuRowIndex() === null }, click: selectAll">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx">Все</span>
                <span class="menu-list_count" data-bind="text: totalCount"></span>
            </a>
            <!-- ko if: isMenuVisible -->
                <!-- ko foreach: menu -->
                <a class="menu-list_i menu-list_i__post" data-bind="css: { active : $root.activeMenuRowIndex() === $root.menu.indexOf($data) }, css2: cssClass, click: select, visible: count() > 0">
                    <span class="menu-list_ico"></span>
                    <span class="menu-list_tx" data-bind="text: title"></span>
                    <span class="menu-list_count" data-bind="text: count"></span>
                </a>
                <!-- /ko -->
            <!-- /ko -->
        </div>
        <div class="margin-15">
            <a href="<?=$this->createUrl('tags/index', array('type' => 0))?>" class="font-middle ">
                <span class="ico-tags margin-r15"></span>Все теги
            </a>
        </div>
    </div>

    <div class="col-23-middle clearfix">
        <div class="heading-title clearfix">
            <div class="sidebar-search sidebar-search__gray float-r">
                <input type="text" class="sidebar-search_itx" placeholder="Введите слово или тег" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'">
                <button class="sidebar-search_btn"></button>
            </div>
            <!-- ko if: filter() === null -->
            Мое избранное
            <!-- /ko -->
            <!-- ko if: filter() !== null -->
            <div class="favorites-search_tx-hold">
                <span class="ico-tag" data-bind="visible: filter().type == 0"></span>
                <span class="favorites-search_tx" data-bind="text: filter().value">Ccвадьба</span>
                <span class="favorites-search_count" data-bind="text: '(' + filter().count + ')'">(88)</span>
                <a class="favorites-search_tx-del ico-close" data-bind="click: removeFilter"></a>
            </div>
            <!-- /ko -->
        </div>

        <div class="col-gray clearfix">
            <!-- ko foreach: favourites -->
                <div data-bind="html: html"></div>
            <!-- /ko -->

            <div class="infscr-loading-hold" data-bind="visible: loading">
                <div id="infscr-loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif"><div>Загрузка</div></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        favouritesModel = new FavouritesViewModel(<?=CJSON::encode($data)?>);
        ko.applyBindings(favouritesModel);
    });
</script>