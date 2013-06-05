<?php
/**
 * @var $data
 */

Yii::app()->clientScript
    ->registerScriptFile('/javascripts/ko_search.js')
;
?>

<div class="content-search">
    <div class="content-search_top clearfix">
        <div class="content-search_t">Я ищу</div>
        <div class="content-search_itx-hold">
            <input type="text" name="" id="" class="content-search_itx" placeholder="Введите слово " data-bind="value: instantaneousQuery, valueUpdate: 'keyup'">
            <button class="content-search_btn"></button>
        </div>
    </div>
    <div class="content-search_utility clearfix">
        <div class="content-search_found" data-bind="if: loaded">Найдено <span class="search-highlight" data-bind="text: totalCount"></span></div>
        <div class="content-search_select">
            <div class="chzn-bluelight">
                <select data-bind="options: scoringValues,
                        value: scoring,
                        optionsValue: function(value) {
                            return scoringValues.indexOf(value);
                        },
                        optionsText: function(value) {
                            return value;
                        },
                        chosen: {}">
                </select>
            </div>
        </div>
        <div class="content-search_pager-control">
            <span class="content-search_pager-control-tx">Показывать на странице </span>
            <!-- ko foreach: perPageValues -->
                <!-- ko if: $root.perPage() == $data -->
                <span class="content-search_pager-control-a" data-bind="text: $data"></span>
                <!-- /ko -->
                <!-- ko if: $root.perPage() != $data -->
                <a class="content-search_pager-control-a" data-bind="text: $data, click: $root.setPerPage"></a>
                <!-- /ko -->
                <span class="content-search_pager-control-separator" data-bind="visible: $root.perPageValues.length != ($root.perPageValues.indexOf($data) + 1)">|</span>
            <!-- /ko -->
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-1" data-bind="if: loaded">
        <div class="menu-list menu-list__favorites">
            <a class="menu-list_i menu-list_i__all2" data-bind="css: { active : activeMenuRowIndex() === null }, click: selectAll">
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
    </div>

    <div class="col-23 clearfix">
        <div data-bind="html: resultsToShow"></div>

        <div id="infscr-loading" data-bind="visible: loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif"><div>Загрузка</div></div>

        <div class="pagination pagination-center clearfix" data-bind="visible: ! loading() && pages().length > 1">
            <div class="pager">
                <ul class="yiiPager" id="">
                    <!-- ko foreach: pages -->
                        <li class="page selected" data-bind="css: { selected : $root.currentPage() == $data }"><a data-bind="text: $data, click: $root.selectPage"></a><img src="/images/pagination_tale.png" data-bind="visible: $root.currentPage() == $data"></li>
                    <!-- /ko -->
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    ko.bindingHandlers.css2 = ko.bindingHandlers.css;

    ko.bindingHandlers.chosen =
    {
        init: function(element)
        {
            $(element).addClass('chzn');
            $(element).chosen();
        },
        update: function(element)
        {
            $(element).trigger('liszt:updated');
        }
    };

    $(function() {
        vm = new SearchViewModel(<?=CJSON::encode($data)?>);
        ko.applyBindings(vm);
    });
</script>