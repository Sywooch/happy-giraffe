<?php Yii::app()->clientScript->registerPackage('ko_friends'); ?>
<div class="layout-wrapper_frame clearfix">
    <?php $this->renderPartial('friends.views._menu'); ?>
    <div class="page-col page-col__friend page-col__aside-in">
        <div class="page-col_hold">
            <div class="page-col_cont">
                <div class="page-col_top">
                    <!-- до определенного числа без >-->
                    <div class="page-col_find-count">Найдено &gt; 500 000</div>
                    <div class="page-col_t-tx">Поиск друзей</div>
                </div>
                <!-- ko if: ! (users().length == 0 && loading() === false) -->
                <div class="friends-list">
                    <div class="friends-list_ul">
                        <!-- ko template: { name : 'search-template', foreach : users } -->
                        <!-- /ko -->
                    </div>
                </div>
                <!-- /ko -->
            </div>
            <div class="page-col_aside aside-filter">
                <form>
                    <div class="aside-filter_top">
                        <div class="sidebar-search clearfix">
                            <input type="text" name="" placeholder="Имя и/или фамилия" class="sidebar-search_itx" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'"/>
                            <!-- При начале ввода добавить класс .active на кнопку-->
                            <button class="sidebar-search_btn" data-bind="click: clearQuery, css: { active : query() != '' }"></button>
                        </div>
                    </div>
                    <div class="aside-filter_hold">
                        <div class="aside-filter_row">
                            <div class="aside-filter_t">Местоположение</div>
                            <div class="margin-b15">
                                <!-- первый option должен быть пустым и без пробелов, для placeholder-->
                                <!-- у всех option должно быть value-->
                                <select data-bind="options: countries,
                                    value: selectedCountry,
                                    optionsText: function(country) {
                                        return country.name;
                                    },
                                    optionsValue: function(country) {
                                        return country.id;
                                    },
                                    optionsCaption: '',
                                    event: { change : updateRegions }" placeholder="Выбор страны" class="select-cus select-cus__blue-searchon">
                                </select>
                            </div>
                            <!-- первый option должен быть пустым и без пробелов, для placeholder-->
                            <select data-bind="options: regions,
                                value: selectedRegion,
                                optionsText: function(region) {
                                    return region.name;
                                },
                                optionsValue: function(region) {
                                    return region.id;
                                },
                                optionsCaption: '',
                                chosen: {}" placeholder="Населенный пункт" class="select-cus select-cus__blue-searchon">
                            </select>
                        </div>
                        <div class="aside-filter_row clearfix">
                            <div class="aside-filter_t">Возраст</div>
                            <div class="display-ib w-75">
                                <select placeholder="От" class="select-cus select-cus__blue" data-bind="options: ages, value: minAge">
                                </select>
                            </div>
                            <div class="aside-filter_label">- </div>
                            <div class="display-ib w-75">
                                <select placeholder="До" class="select-cus select-cus__blue" data-bind="options: ages, value: maxAge">
                                </select>
                            </div>
                        </div>
                        <div class="aside-filter_row clearfix">
                            <div class="aside-filter_t">Пол</div>
                            <input id="radio3" type="radio" name="b-radio2" data-bind="checked: gender" class="aside-filter_radio">
                            <label for="radio3" class="aside-filter_label-radio">любой</label>
                            <input id="radio4" type="radio" name="b-radio2" checked="checked" class="aside-filter_radio" data-bind="checked: gender">
                            <label for="radio4" class="aside-filter_label-radio"><span class="ico-male"></span></label>
                            <input id="radio5" type="radio" name="b-radio2" class="aside-filter_radio" data-bind="checked: gender">
                            <label for="radio5" class="aside-filter_label-radio"><span class="ico-female"></span></label>
                        </div>
                        <div class="aside-filter_sepor"></div>
                        <div class="aside-filter_row clearfix">
                            <div class="aside-filter_t">Дети</div>
                            <div class="margin-b10 clearfix">
                                <input id="radio6" type="radio" name="b-radio3" checked="checked" class="aside-filter_radio">
                                <label for="radio6" class="aside-filter_label-radio">не имеет значения</label>
                            </div>
                            <div class="margin-b10 clearfix">
                                <input id="radio7" type="radio" name="b-radio3" class="aside-filter_radio">
                                <label for="radio7" class="aside-filter_label-radio">срок беременности (недели)</label>
                                <div class="aside-filter_toggle">
                                    <div class="display-ib w-75">
                                        <select placeholder="С" class="select-cus select-cus__blue">
                                            <option></option>
                                            <option value="0">С</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>
                                    <div class="aside-filter_label">- </div>
                                    <div class="display-ib w-75">
                                        <select placeholder="По" class="select-cus select-cus__blue">
                                            <option></option>
                                            <option value="0">По</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="margin-b10 clearfix">
                                <input id="radio8" type="radio" name="b-radio3" class="aside-filter_radio">
                                <label for="radio8" class="aside-filter_label-radio">возраст ребенка (лет)</label>
                                <div class="aside-filter_toggle">
                                    <div class="display-ib w-75">
                                        <select placeholder="От" class="select-cus select-cus__blue">
                                            <option></option>
                                            <option value="0">От</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>
                                    <div class="aside-filter_label">- </div>
                                    <div class="display-ib w-75">
                                        <select placeholder="До" class="select-cus select-cus__blue">
                                            <option></option>
                                            <option value="0">До</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="margin-b10 clearfix">
                                <input id="radio9" type="radio" name="b-radio3" class="aside-filter_radio">
                                <label for="radio9" class="aside-filter_label-radio">многодетная семья</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new FriendsSearchViewModel(<?= CJSON::encode($json) ?>);
        ko.applyBindings(vm);
    });
</script>

<?php $this->renderPartial('/_searchCard'); ?>
