<?php
    Yii::app()->clientScript
        ->registerScriptFile('/javascripts/knockout-2.2.1.js')
        ->registerScriptFile('/javascripts/ko_friendsSearch.js')
    ;
?>

<div class="content-cols">
    <div class="col-1">
        <h2 class="col-1_t"> Найти друзей
            <div class="col-1_sub-t"><a href="<?=$this->createUrl('/friends/default/index')?>" class="">Мои друзья</a></div>
        </h2>
        <div class="aside-filter">
            <form action="">
            <div class="aside-filter_search clearfix">
                <input type="text" class="aside-filter_search-itx" placeholder="Введите имя и/или фамили" data-bind="value: query, valueUpdate: 'keyup'">
                <!--
                В начале ввода текста, скрыть aside-filter_search-btn добавить класс active"
                 -->
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
                        event: { change : updateRegions }">

                        </select>
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
                        chosen: {}">

                        </select>
                    </div>
                </div>
            </div>
            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row clearfix">
                <div class="aside-filter_t">Пол</div>
                <input type="radio" name="b-radio2" id="radio3" class="aside-filter_radio" value='' data-bind="checked: gender">
                <label for="radio3" class="aside-filter_label-radio">
                    все
                </label>
                <input type="radio" name="b-radio2" id="radio4" class="aside-filter_radio" value='1' data-bind="checked: gender">
                <label for="radio4" class="aside-filter_label-radio">
                    <span class="ico-male"></span>
                </label>
                <input type="radio" name="b-radio2" id="radio5" class="aside-filter_radio" value='0' data-bind="checked: gender">
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
                    <input type="radio" name="b-radio3" id="radio6" class="aside-filter_radio" checked>
                    <label for="radio6" class="aside-filter_label-radio">не имеет значения</label>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="radio" name="b-radio3" id="radio7" class="aside-filter_radio">
                    <label for="radio7" class="aside-filter_label-radio">срок беременности (недели)</label>
                    <div class="aside-filter_toggle">
                        <div class="aside-filter_label">от</div>
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select class="chzn">
                                <option selected="selected">0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>32</option>
                                <option>32</option>
                                <option>32</option>
                                <option>32</option>
                                <option>132</option>
                                <option>132</option>
                                <option>132</option>
                            </select>
                        </div>
                        <div class="aside-filter_label">до</div>
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select class="chzn">
                                <option selected="selected">0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>32</option>
                                <option>32</option>
                                <option>32</option>
                                <option selected='selected'>32</option>
                                <option>132</option>
                                <option>132</option>
                                <option>132</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="radio" name="b-radio3" id="radio8" class="aside-filter_radio">
                    <label for="radio8" class="aside-filter_label-radio">возраст ребенка (лет)</label>
                    <div class="aside-filter_toggle">
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select class="chzn">
                                <option selected="selected">0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>32</option>
                                <option>32</option>
                                <option>32</option>
                                <option>32</option>
                                <option>132</option>
                                <option>132</option>
                                <option>132</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="margin-b10 clearfix">
                    <input type="radio" name="b-radio3" id="radio9" class="aside-filter_radio">
                    <label for="radio9" class="aside-filter_label-radio">многодетная семья</label>
                    <div class="aside-filter_toggle">
                        <div class="chzn-bluelight chzn-textalign-c w-75">
                            <select class="chzn">
                                <option selected="selected">0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>32</option>
                                <option>32</option>
                                <option>32</option>
                                <option>32</option>
                                <option>132</option>
                                <option>132</option>
                                <option>132</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="aside-filter_sepor"></div>
            <div class="aside-filter_row clearfix">
                <button class="aside-filter_reset"><span class="aside-filter_reset-tx" data-bind="click: clearForm">Сбросить параметры</span></button>
                <button class="btn-h46 btn-gold float-r" data-bind="click: search">Найти</button>
            </div>
        </form>
        </div>
    </div>

    <div class="col-23 clearfix">

        <div class="friends-list">
            <!-- ko foreach: users -->
            <div class="friends-list_i" data-bind="html: $data"></div>
            <!-- /ko -->

            <div id="infscr-loading" data-bind="visible: loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
        vm = new FriendsSearchViewModel(<?=CJSON::encode($data)?>);
        ko.applyBindings(vm);
    });
</script>