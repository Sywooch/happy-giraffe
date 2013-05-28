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
            <!-- ko if: isMenuVisible -->
                <!-- ko foreach: menu -->
                <a href="javascript:void(0)" class="menu-list_i" data-bind="css: { active : $root.activeMenuRow() === entity }, css2: cssClass, click: select, visible: count() > 0">
                    <span class="menu-list_ico"></span>
                    <span class="menu-list_tx" data-bind="text: title"></span>
                    <span class="menu-list_count" data-bind="text: count"></span>
                </a>
                <!-- /ko -->
            <!-- /ko -->
        </div>
        <div class="margin-15">
            <a href="<?=$this->createUrl('tags/index', array('type' => TagsController::TYPE_POPULAR))?>" class="font-middle ">
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
                <input type="text" class="favorites-search_itx ui-autocomplete-input" placeholder="Введите слово или тег" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'">
                <!--
                В начале ввода текста добавить класс active
                 -->
                <button class="favorites-search_btn" data-bind="css: { active : throttledQuery() != '' }, click: clearQuery"></button>
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
            <div class="entry-hold">
                <div data-bind="html: html"></div>

                <div class="entry-tags">
                    <div class="entry-tags_row" data-bind="visible: tags().length > 0">
                        <span class="entry-tags_t">Теги:</span>
                        <!-- ko foreach: tags -->
                        <a class="entry-tags_tag" data-bind="text: $data, attr: { href : '/favourites/?query=' + $data }"></a>
                        <!-- /ko -->
                    </div>
                    <div class="entry-tags_row">
                        <div class="entry-tags_tx" data-bind="visible: note() != '', text: note"></div>
                    </div>
                    <div class="entry-tags_edit">
                        <a href="javascript: void(0)" class="entry-tags_edit-a powertip" title="Редактировать" data-bind="click: showEditForm"></a>

                        <!-- ko if: editing -->
                            <div class="favorites-add-popup" data-bind="with: editing">
                                <div class="favorites-add-popup_t">Редактировать</div>
                                <div class="favorites-add-popup_i clearfix">
                                    <img class="favorites-add-popup_i-img" data-bind="attr: { src : image, alt: title }">
                                    <div class="favorites-add-popup_i-hold" data-bind="text: title"></div>
                                </div>
                                <div class="favorites-add-popup_row">
                                    <label for="" class="favorites-add-popup_label">Теги:</label>
                                    <!-- ko foreach: tags -->
                                    <span class="favorites-add-popup_tag">
                                        <a class="favorites-add-popup_tag-a" data-bind="text: $data, attr: { href : '/favourites/default/index/?query=' + $data }"></a>
                                        <a href="javascript:void(0)" class="ico-close" data-bind="click: $parent.removeTag"></a>
                                    </span>
                                    <!-- /ko -->
                                </div>
                                <div class="favorites-add-popup_row margin-b10" data-bind="visible: ! tagsInputIsVisible(), click: showTagsForm">
                                    <a class="textdec-none" href="">
                                        <span class="ico-plus2 margin-r5"></span>
                                        <span class="a-pseudo-gray color-gray">Добавить</span>
                                    </a>
                                </div>
                                <div class="favorites-add-popup_row margin-b10" data-bind="visible: tagsInputIsVisible">
                                    <input type="text" class="favorites-add-popup_itx-tag ui-autocomplete-input" placeholder="Вводите теги через запятую или Enter" data-bind="value: tagsInputValue, valueUpdate: 'keyup', event: { keypress : tagHandler }">
                                </div>
                                <div class="favorites-add-popup_row">
                                    <label for="" class="favorites-add-popup_label">Комментарий</label>
                                    <div class="float-r color-gray" data-bind="text: note().length + '/150'"></div>
                                </div>
                                <div class="favorites-add-popup_row">
                                    <textarea name="" id="" cols="25" rows="2" class="favorites-add-popup_textarea" placeholder="Введите комментарий" data-bind="value: note, valueUpdate: 'keyup'" maxlength="150"></textarea>
                                </div>
                                <div class="favorites-add-popup_row textalign-c margin-t15">
                                    <a href="javascript:void(0)" class="btn-gray-light" data-bind="click: $parent.cancel">Отменить</a>
                                    <a href="javascript:void(0)" class="btn-green" data-bind="click: $parent.edit">Сохранить</a>
                                </div>
                            </div>
                        <!-- /ko -->
                    </div>
                </div>
            </div>
        <!-- /ko -->

        <div id="infscr-loading" data-bind="visible: loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif"><div>Загрузка</div></div>
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