<?php
Yii::app()->clientScript
    ->registerPackage('ko_recipes_search')
;

$this->widget('FavouriteWidget', array('registerScripts' => true));
?>

<div class="content-cols clearfix">
    <div class="col-1">

        <div class="aside-filter">

            <div class="aside-filter_search clearfix">
                <input type="text" class="aside-filter_search-itx" placeholder="Поиск рецепта" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'">
                <button class="aside-filter_search-btn" data-bind="click: clearQuery, css: { active : instantaneousQuery() != '' }"></button>
            </div>
            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row margin-b10 clearfix">
                <div class="aside-filter_t">Тип блюда</div>
                <div class="chzn-bluelight">
                    <select class="chzn" data-bind="options: recipeTypes, optionsText: 'title', optionsValue: 'id', value: selectedRecipeType, chosen: {}" data-placeholder="Любой"></select>
                </div>
            </div>
            <div class="aside-filter_row margin-b10 clearfix">
                <div class="aside-filter_t">Кухня</div>
                <div class="chzn-bluelight">
                    <select class="chzn" data-bind="options: cuisines, optionsText: 'title', optionsValue: 'id', value: selectedCuisine, chosen: {}" data-placeholder="Любая"></select>
                </div>
            </div>
            <div class="aside-filter_sepor"></div>

            <div class="aside-filter_row margin-b10 clearfix">
                <div class="aside-filter_t">Затраченное время</div>
                <div class="chzn-bluelight">
                    <select class="chzn" data-bind="options: durations, optionsText: 'title', optionsValue: 'id', value: selectedDuration, chosen: {}" data-placeholder="Не важно"></select>
                </div>
            </div>
            <div class="aside-filter_sepor"></div>

            <div class="aside-filter_row clearfix">
                <div class="aside-filter_t">Диетические предпочтения</div>
                <div class="margin-b10 clearfix">
                    <input type="checkbox" name="b-radio3" id="checkbox9" class="aside-filter_radio" data-bind="checked: forDiabetics1">
                    <label for="checkbox9" class="aside-filter_label-radio aside-filter_label-radio__checkbox">Для диабетиков</label>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="checkbox" name="b-radio3" id="checkbox10" class="aside-filter_radio" data-bind="checked: lowCal">
                    <label for="checkbox10" class="aside-filter_label-radio aside-filter_label-radio__checkbox">Низкокалорийные</label>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="checkbox" name="b-radio3" id="checkbox11" class="aside-filter_radio" data-bind="checked: forDiabetics2">
                    <label for="checkbox11" class="aside-filter_label-radio aside-filter_label-radio__checkbox">Низкоуглеводные</label>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="checkbox" name="b-radio3" id="checkbox12" class="aside-filter_radio" data-bind="checked: lowFat">
                    <label for="checkbox12" class="aside-filter_label-radio aside-filter_label-radio__checkbox">Низкожирные</label>
                </div>

            </div>

        </div>
        <div class="clearfix">
            <a class="a-pseudo-gray float-r margin-r5" data-bind="click: reset">Сбросить все</a>
        </div>
    </div>
    <div class="col-23-middle ">

        <!-- ko if: ! loading() -->
            <div class="i-search-t">Найдено  <span class="i-highlight" data-bind="text: count"></span>   рецептов</div>

            <div class="col-gray" data-bind="html: posts">


            </div>
        <!-- /ko -->
        <!-- ko if: loading -->
            <div id="infscr-loading" data-bind="visible: loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
        <!-- /ko -->
    </div>
</div>

<script type="text/javascript">
    $(function() {
        recipeSearchVM = new RecipesSearchViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(recipeSearchVM);
    });
</script>