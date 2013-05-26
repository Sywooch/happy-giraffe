<?php
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/knockout-2.2.1.js')
    ->registerScriptFile('/javascripts/ko_favourites.js?t=' . time())
;
?>

<div class="content-cols clearfix">
    <div class="col-1">
        <h2 class="col-1_t">Избранное</h2>

        <div class="menu-list menu-list__favorites">
            <a href="javascript:void(0)" class="menu-list_i menu-list_i__all" data-bind="css : { active : activeMenuRow() === null }, click: selectAll">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx">Все</span>
                <span class="menu-list_count" data-bind="text: totalCount"></span>
            </a>
            <!-- ko foreach: menu -->
            <a href="javascript:void(0)" class="menu-list_i" data-bind="css: { active : $root.activeMenuRow() === entity }, click: select">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx" data-bind="text: title"></span>
                <span class="menu-list_count" data-bind="text: count"></span>
            </a>
            <!-- /ko -->
        </div>
        <div class="margin-15">
            <a href="<?=$this->createUrl('tags/index')?>" class="font-middle ">
                <span class="ico-tags margin-r15"></span>Все теги
            </a>
        </div>
    </div>

    <div class="col-23 clearfix">
        <!--
        favorites-search__found - при осуществленном поиске
          -->
        <div class="favorites-search clearfix" data-bind="css: { 'favorites-search__found' : filter() !== null }">
            <div class="favorites-search_hold clearfix">
                <input type="text" class="favorites-search_itx ui-autocomplete-input" placeholder="Введите слово или тег" data-bind="value: query, valueUpdate: 'keyup'">
                <!--
                В начале ввода текста добавить класс active
                 -->
                <button class="favorites-search_btn" data-bind="css: { active : query() != '' }, click: clearQuery"></button>
            </div>
            <!-- Блок с поисковым запросом -->
            <div class="favorites-search_tx-hold" data-bind="if: filter">
                <span class="ico-tag" data-bind="visible: filter().type == 0"></span>
                <span class="favorites-search_tx" data-bind="text: filter().value"></span>
                <span class="favorites-search_count" data-bind="text: '(' + filter().count + ')'"></span>
                <a href="javascript:void(0)" class="favorites-search_tx-del ico-close" data-bind="click: removeFilter"></a>
            </div>
        </div>

        <!-- ko foreach: favourites -->
            <div data-bind="html: html"></div>
        <!-- /ko -->
    </div>
</div>

<script type="text/javascript">
    ko.bindingHandlers.tooltip = {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
            $(element).data('powertip', valueAccessor());
        },
        update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
            $(element).data('powertip', valueAccessor());
            $(element).powerTip({
                placement: 'n',
                smartPlacement: true,
                popupId: 'tooltipsy-im',
                offset: 8
            });
        }
    };

    $(function() {
        vm = new FavouritesViewModel(<?=CJSON::encode($data)?>);
        ko.applyBindings(vm);
    });
</script>