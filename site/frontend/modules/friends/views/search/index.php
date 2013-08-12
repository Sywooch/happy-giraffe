<?php
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/ko_friends.js')
    ->registerScriptFile('/javascripts/ko_friendsSearch.js')
;
?>

<div class="content-cols">
    <div class="col-1">
        &nbsp;
    </div>
    <div class="col-23">
        <ul class="breadcrumbs-big clearfix">
            <li class="breadcrumbs-big_i">
                <a class="breadcrumbs-big_a" href="<?=$this->createUrl('/friends/default/index')?>">Мои друзья (<?=$friendsCount?>)</a>
            </li>
            <li class="breadcrumbs-big_i">Найти друзей </li>
        </ul>
    </div>
</div>
<div class="content-cols">
    <div class="col-1">
        <div class="aside-filter">
            <form action="">
            <div class="aside-filter_search clearfix">
                <input type="text" class="aside-filter_search-itx" placeholder="Имя и/или фамилия" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'">
                <button class="aside-filter_search-btn" data-bind="click: clearQuery, css: { active : query() != '' }""></button>
            </div>
            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row clearfix">
                <div class="aside-filter_t">Местоположение</div>
                <div class="display-ib">
                    <input type="radio" name="b-radio1" id="radio1" class="aside-filter_radio" value="0" data-bind="checked: location">
                    <label for="radio1" class="aside-filter_label-radio">везде</label>
                </div>
                <input type="radio" name="b-radio1" id="radio2" class="aside-filter_radio" value="1" data-bind="checked: location">
                <label for="radio2" class="aside-filter_label-radio">указать где</label>
                <div class="aside-filter_toggle">
                    <div class="chzn-bluelight">
                        <select data-bind="options: countries,
                        value: selectedCountry,
                        optionsText: function(country) {
                            return country.name;
                        },
                        optionsValue: function(country) {
                            return country.id;
                        },
                        optionsCaption: 'Выберите страну',
                        chosen: {},
                        event: { change : updateRegions }"></select>
                    </div>
                </div>
                <div class="aside-filter_toggle" data-bind="visible: regions().length > 0">
                    <div class="chzn-bluelight">
                        <select data-bind="options: regions,
                        value: selectedRegion,
                        optionsText: function(region) {
                            return region.name;
                        },
                        optionsValue: function(region) {
                            return region.id;
                        },
                        optionsCaption: 'Выберите регион',
                        chosen: {}"></select>
                    </div>
                </div>
            </div>
            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row clearfix">
                <div class="aside-filter_t">Пол</div>
                <input type="radio" name="b-radio2" id="radio3" class="aside-filter_radio" value="" data-bind="checked: gender">
                <label for="radio3" class="aside-filter_label-radio">
                    любой
                </label>
                <input type="radio" name="b-radio2" id="radio4" class="aside-filter_radio" value="1" data-bind="checked: gender">
                <label for="radio4" class="aside-filter_label-radio">
                    <span class="ico-male"></span>
                </label>
                <input type="radio" name="b-radio2" id="radio5" class="aside-filter_radio" value="0" data-bind="checked: gender">
                <label for="radio5" class="aside-filter_label-radio">
                    <span class="ico-female"></span>
                </label>
            </div>
            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row margin-b20 clearfix">
                <div class="aside-filter_t">Возраст</div>
                <div class="aside-filter_label">от</div>
                <div class="chzn-bluelight chzn-textalign-c w-75">
                    <select data-bind="options: ages, value: minAge, chosen: {}"></select>
                </div>
                <div class="aside-filter_label">до</div>
                <div class="chzn-bluelight chzn-textalign-c w-75">
                    <select data-bind="options: ages, value: maxAge, chosen: {}"></select>
                </div>
            </div>
            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row  margin-b20 clearfix ">
                <div class="aside-filter_t">Семейное положение</div>
                <div class="chzn-bluelight">
                    <select data-bind="options: relationStatuses,
                    value: selectedRelationStatus,
                    optionsText: function(region) {
                        return region.name;
                    },
                    optionsValue: function(region) {
                        return region.id;
                    },
                    optionsCaption: 'не имеет значения',
                    chosen: {}"></select>
                </div>
            </div>
            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row clearfix">
                <div class="aside-filter_t">Дети</div>
                <div class="margin-b10 clearfix">
                    <input type="radio" name="b-radio3" id="radio6" class="aside-filter_radio" value="0" data-bind="checked: childrenType">
                    <label for="radio6" class="aside-filter_label-radio">не имеет значения</label>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="radio" name="b-radio3" id="radio7" class="aside-filter_radio" value="1" data-bind="checked: childrenType">
                    <label for="radio7" class="aside-filter_label-radio">срок беременности (недели)</label>
                    <div class="aside-filter_toggle">
                        <div class="aside-filter_label">от</div>
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select data-bind="options: pregnancyWeeks, value: pregnancyWeekMin, chosen: {}"></select>
                        </div>
                        <div class="aside-filter_label">до</div>
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select data-bind="options: pregnancyWeeks, value: pregnancyWeekMax, chosen: {}"></select>
                        </div>
                    </div>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="radio" name="b-radio3" id="radio8" class="aside-filter_radio" value="2" data-bind="checked: childrenType">
                    <label for="radio8" class="aside-filter_label-radio">возраст ребенка (лет)</label>
                    <div class="aside-filter_toggle">
                        <div class="aside-filter_label">от</div>
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select data-bind="options: childAges, value: childAgeMin, chosen: {}"></select>
                        </div>
                        <div class="aside-filter_label">до</div>
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select data-bind="options: childAges, value: childAgeMax, chosen: {}"></select>
                        </div>
                    </div>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="radio" name="b-radio3" id="radio9" class="aside-filter_radio" value="3" data-bind="checked: childrenType">
                    <label for="radio9" class="aside-filter_label-radio">многодетная семья</label>
                </div>

            </div>

        </form>
        </div>
        <div class="clearfix">
            <a class="a-pseudo-gray float-r margin-r5" data-bind="click: clearForm">Сбросить все</a>
        </div>
    </div>

    <div class="col-23-middle col-gray clearfix">

        <!-- ko if: users().length == 0 && loading() === false -->
        <div class="cap-empty cap-empty__rel">
            <div class="cap-empty_hold">
                <div class="cap-empty_tx">По данным параметрам ничего не найдено.</div>
                <span class="color-gray">Измените параметры поиска</span>
            </div>
        </div>
        <!-- /ko -->

        <!-- ko if: ! (users().length == 0 && loading() === false) -->
        <div class="friends-list friends-list__family margin-t20">
            <!-- ko template: { name : 'request-template', foreach : users } -->

            <!-- /ko -->

            <div id="infscr-loading" data-bind="visible: loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
        </div>
        <!-- /ko -->

    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new FriendsSearchViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(vm);
    });
</script>

<?php $this->renderPartial('/_requestTemplate'); ?>