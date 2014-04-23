<?php Yii::app()->clientScript->registerPackage('ko_friends'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.history.js', CClientScript::POS_HEAD); ?>
<?php $this->pageTitle = 'Мои друзья'; ?>
<?php $this->bodyClass = 'body__bg-base';?>
<div class="layout-wrapper_frame clearfix">
    <?php $this->renderPartial('friends.views._menu'); ?>
    <div class="page-col page-col__friend page-col__aside-in">
        <div class="page-col_hold">
            <div class="page-col_cont">
                <div class="page-col_top">
                    <!-- до определенного числа без >-->
                    <div class="page-col_find-count" data-bind="visible: itemCount">Найдено <span data-bind="text: itemCount"></span></div>
                    <div class="page-col_t-tx">Поиск друзей</div>
                </div>
                <!-- ko if: ! (users().length == 0 && loading() === false) -->
                <div class="friends-list">
                    <ul class="friends-list_ul">
                        <!-- ko template: { name : 'search-template', foreach : users } -->
                        <!-- /ko -->
                    </ul>
                    <div class="loader loader__b-gray" data-bind="visible: loading"><img src="/images/ico/ajax-loader.gif" class="loader_img">
                        <div class="loader_tx">Загрузка пользователей</div>
                    </div>
                </div>
                <!-- /ko -->
            </div>
            <div class="page-col_aside aside-filter">
                <div class="aside-filter_top">
                    <div class="sidebar-search clearfix">
                        <input type="text" name="" placeholder="Имя и/или фамилия" class="sidebar-search_itx" data-bind="value: instantaneousQuery, valueUpdate: 'keyup'"/>
                        <!-- При начале ввода добавить класс .active на кнопку-->
                        <button class="sidebar-search_btn" data-bind="click: clearQuery, css: { active : instantaneousQuery() != '' }"></button>
                    </div>
                </div>
                <div class="aside-filter_hold">
                    <div class="aside-filter_row">
                        <div class="aside-filter_t">Местоположение</div>
                        <div class="margin-b15">
                            <!-- первый option должен быть пустым и без пробелов, для placeholder-->
                            <!-- у всех option должно быть value-->
                            <select data-bind="
                                options: countries,
                                value: selectedCountry,
                                optionsText: 'name',
                                optionsValue: 'id',
                                optionsCaption: '',
                                select2: {
                                    width: '100%',
                                    dropdownCssClass: 'select2-drop__search-on',
                                    escapeMarkup: function(m) { return m; }
                                }
                            " placeholder="Выбор страны" class="select-cus select-cus__blue-searchon select-cus__blue">
                            </select>
                        </div>
                        <!-- первый option должен быть пустым и без пробелов, для placeholder-->
                        <select data-bind="
                            options: regions,
                            value: selectedRegion,
                            optionsText: 'name',
                            optionsValue: 'id',
                            optionsCaption: '',
                            select2: {
                                width: '100%',
                                dropdownCssClass: 'select2-drop__search-on',
                                escapeMarkup: function(m) { return m; }
                            }
                        " placeholder="Населенный пункт" class="select-cus select-cus__blue">
                        </select>
                    </div>
                    <div class="aside-filter_row clearfix">
                        <div class="aside-filter_t">Возраст</div>
                        <div class="display-ib w-75 verticalalign-m">
                            <select placeholder="От" class="select-cus select-cus__blue" data-bind="
                                options: ages,
                                value: minAge,
                                optionsCaption: '',
                                select2: {
                                    width: '100%',
                                    minimumResultsForSearch: -1,
                                    dropdownCssClass: 'select2-drop__search-off',
                                    escapeMarkup: function(m) { return m; }
                                }
                            ">
                            </select>
                        </div>
                        <div class="aside-filter_label">- </div>
                        <div class="display-ib w-75 verticalalign-m">
                            <select placeholder="До" class="select-cus select-cus__blue" data-bind="
                                options: ages,
                                value: maxAge,
                                optionsCaption: '',
                                select2: {
                                    width: '100%',
                                    minimumResultsForSearch: -1,
                                    dropdownCssClass: 'select2-drop__search-off',
                                    escapeMarkup: function(m) { return m; }
                                }
                            ">
                            </select>
                        </div>
                    </div>
                    <div class="aside-filter_row clearfix">
                        <div class="aside-filter_t">Пол</div>
                        <input id="radio3" type="radio" name="b-radio2" data-bind="checked: gender" value="" class="aside-filter_radio">
                        <label for="radio3" class="aside-filter_label-radio">любой</label>
                        <input id="radio4" type="radio" name="b-radio2" checked="checked" class="aside-filter_radio" data-bind="checked: gender" value="1">
                        <label for="radio4" class="aside-filter_label-radio"><span class="ico-male"></span></label>
                        <input id="radio5" type="radio" name="b-radio2" class="aside-filter_radio" data-bind="checked: gender" value="0">
                        <label for="radio5" class="aside-filter_label-radio"><span class="ico-female"></span></label>
                    </div>
                    <div class="aside-filter_sepor"></div>
                    <div class="aside-filter_row clearfix">
                        <div class="aside-filter_t">Дети</div>
                        <div class="margin-b10 clearfix">
                            <input id="radio6" type="radio" name="b-radio3" class="aside-filter_radio" value="0" data-bind="checked: childrenType">
                            <label for="radio6" class="aside-filter_label-radio">не имеет значения</label>
                        </div>
                        <div class="margin-b10 clearfix">
                            <input id="radio7" type="radio" name="b-radio3" class="aside-filter_radio" value="1" data-bind="checked: childrenType">
                            <label for="radio7" class="aside-filter_label-radio">срок беременности (недели)</label>
                            <div class="aside-filter_toggle">
                                <div class="display-ib w-75 verticalalign-m">
                                    <select placeholder="С" class="select-cus select-cus__blue" data-bind="
                                        options: pregnancyWeeks,
                                        value: pregnancyWeekMin,
                                        optionsCaption: '',
                                        select2: {
                                            width: '100%',
                                            minimumResultsForSearch: -1,
                                            dropdownCssClass: 'select2-drop__search-off',
                                            escapeMarkup: function(m) { return m; }
                                        }
                                    ">
                                    </select>
                                </div>
                                <div class="aside-filter_label">- </div>
                                <div class="display-ib w-75 verticalalign-m">
                                    <select placeholder="По" class="select-cus select-cus__blue" data-bind="
                                        options: pregnancyWeeks,
                                        value: pregnancyWeekMax,
                                        optionsCaption: '',
                                        select2: {
                                            width: '100%',
                                            minimumResultsForSearch: -1,
                                            dropdownCssClass: 'select2-drop__search-off',
                                            escapeMarkup: function(m) { return m; }
                                        }
                                    ">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="margin-b10 clearfix">
                            <input id="radio8" type="radio" name="b-radio3" class="aside-filter_radio" value="2" data-bind="checked: childrenType">
                            <label for="radio8" class="aside-filter_label-radio">возраст ребенка (лет)</label>
                            <div class="aside-filter_toggle">
                                <div class="display-ib w-75 verticalalign-m">
                                    <select placeholder="От" class="select-cus select-cus__blue" data-bind="
                                        options: childAges,
                                        value: childAgeMin,
                                        optionsCaption: '',
                                        select2: {
                                            width: '100%',
                                            minimumResultsForSearch: -1,
                                            dropdownCssClass: 'select2-drop__search-off',
                                            escapeMarkup: function(m) { return m; }
                                        }
                                    ">
                                    </select>
                                </div>
                                <div class="aside-filter_label">- </div>
                                <div class="display-ib w-75 verticalalign-m">
                                    <select placeholder="До" class="select-cus select-cus__blue" data-bind="
                                        options: childAges,
                                        value: childAgeMax,
                                        optionsCaption: '',
                                        select2: {
                                            width: '100%',
                                            minimumResultsForSearch: -1,
                                            dropdownCssClass: 'select2-drop__search-off',
                                            escapeMarkup: function(m) { return m; }
                                        }
                                    ">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="margin-b10 clearfix">
                            <input id="radio9" type="radio" name="b-radio3" class="aside-filter_radio" value="3" data-bind="checked: childrenType">
                            <label for="radio9" class="aside-filter_label-radio">многодетная семья</label>
                        </div>
                    </div>
                    <div class="aside-filter_row clearfix">
                        <div class="float-r margin-t10"><a class="color-white a-pseudo" data-bind="click: clearForm">Сбросить фильтр </a></div>
                    </div>
                </div>
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
