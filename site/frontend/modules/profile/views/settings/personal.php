<?php
/**
 * @var SettingsController $this
 */
Yii::app()->clientScript->registerScriptFile('/javascripts/settings.js'); ?>
<div id="personal-settings">

    <div data-bind="template: { name: 'attribute-template', data: first_name }"></div>

    <div data-bind="template: { name: 'attribute-template', data: last_name }"></div>

    <div data-bind="template: { name: 'birthday-template', data: birthday}"></div>

    <div class="margin-b20 clearfix">
        <div class="form-settings_label">Пол</div>
        <div class="form-settings_elem">
            <div class="b-radio-icons">
                <!-- Данные для примера id="radio4" name="b-radio2" и for="radio4" -->
                <input type="radio" name="b-radio2" id="radio4" class="b-radio-icons_radio" checked="">
                <label for="radio4" class="b-radio-icons_label">
                    <span class="ico-male"></span>
                </label>
                <!-- Данные для примера id="radio5" name="b-radio2" и for="radio5" -->
                <input type="radio" name="b-radio2" id="radio5" class="b-radio-icons_radio">
                <label for="radio5" class="b-radio-icons_label">
                    <span class="ico-female"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="margin-b20 clearfix">
        <div class="form-settings_label">E-mail</div>
        <div class="form-settings_elem">
            <div>
                <span><?=$this->user->email ?></span>
            </div>
        </div>
    </div>

    <div class="margin-b20 clearfix">
        <div class="form-settings_label">Место жительства</div>
        <div class="form-settings_elem">
            <div class="">
                <div class="location clearfix display-ib verticalalign-m">
                    <span class="flag-big flag-big-ua"></span>
                    <span class="location_tx">Ярославская обл. <br>Переславль-Залесский</span>
                </div>
                <a class="a-pseudo-icon" href="">
                    <span class="ico-edit"></span>
                    <span class="a-pseudo-icon_tx">Редактировать</span>
                </a>
            </div>
            <!-- Блок редатирования поля -->
            <div class="display-n">
            </div>
        </div>
    </div>

    <div class="margin-b20 clearfix">
        <div class="form-settings_label">Место жительства</div>
        <div class="form-settings_elem">
            <div class="display-n">
                <div class="location clearfix display-ib verticalalign-m">
                    <span class="flag-big flag-big-ua"></span>
                    <span class="location_tx">Ярославская обл. <br>Переславль-Залесский</span>
                </div>
                <a class="a-pseudo-icon" href="">
                    <span class="ico-edit"></span>
                    <span class="a-pseudo-icon_tx">Редактировать</span>
                </a>
            </div>
            <!-- Блок редатирования поля -->
            <div class="">
                <div class="w-300 margin-b5">
                    <div class="chzn-gray">
                        <select class="chzn chzn-done" data-placeholder="Выберите страну" id="sel2PT" style="display: none;">
                            <option value=""></option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                        </select><div id="sel2PT_chzn" class="chzn-container chzn-container-single" style="width: 90px;"><a href="javascript:void(0)" class="chzn-single chzn-default" tabindex="-1"><span>Выберите страну</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 90px; top: 34px;"><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 72px;"></div><ul class="chzn-results"><li id="sel2PT_chzn_o_1" class="active-result" style="">Россия</li><li id="sel2PT_chzn_o_2" class="active-result" style="">Украина</li><li id="sel2PT_chzn_o_3" class="active-result" style="">Беларусь</li><li id="sel2PT_chzn_o_4" class="active-result" style="">Россия</li><li id="sel2PT_chzn_o_5" class="active-result" style="">Украина</li><li id="sel2PT_chzn_o_6" class="active-result" style="">Беларусь</li><li id="sel2PT_chzn_o_7" class="active-result" style="">Россия</li><li id="sel2PT_chzn_o_8" class="active-result" style="">Украина</li><li id="sel2PT_chzn_o_9" class="active-result" style="">Беларусь</li><li id="sel2PT_chzn_o_10" class="active-result" style="">Россия</li><li id="sel2PT_chzn_o_11" class="active-result" style="">Украина</li><li id="sel2PT_chzn_o_12" class="active-result" style="">Беларусь</li></ul></div></div>
                    </div>
                </div>
                <div class="w-300 margin-b5">
                    <div class="chzn-gray">
                        <select class="chzn chzn-done" data-placeholder="Выберите регион" id="sel33M" style="display: none;">
                            <option value=""></option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                            <option>Россия</option>
                            <option>Украина</option>
                            <option>Беларусь</option>
                        </select><div id="sel33M_chzn" class="chzn-container chzn-container-single" style="width: 90px;"><a href="javascript:void(0)" class="chzn-single chzn-default" tabindex="-1"><span>Выберите регион</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 90px; top: 34px;"><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 72px;"></div><ul class="chzn-results"><li id="sel33M_chzn_o_1" class="active-result" style="">Россия</li><li id="sel33M_chzn_o_2" class="active-result" style="">Украина</li><li id="sel33M_chzn_o_3" class="active-result" style="">Беларусь</li><li id="sel33M_chzn_o_4" class="active-result" style="">Россия</li><li id="sel33M_chzn_o_5" class="active-result" style="">Украина</li><li id="sel33M_chzn_o_6" class="active-result" style="">Беларусь</li><li id="sel33M_chzn_o_7" class="active-result" style="">Россия</li><li id="sel33M_chzn_o_8" class="active-result" style="">Украина</li><li id="sel33M_chzn_o_9" class="active-result" style="">Беларусь</li><li id="sel33M_chzn_o_10" class="active-result" style="">Россия</li><li id="sel33M_chzn_o_11" class="active-result" style="">Украина</li><li id="sel33M_chzn_o_12" class="active-result" style="">Беларусь</li></ul></div></div>
                    </div>
                </div>
                <div class="float-l w-300">
                    <input type="text" name="" id="" class="itx-gray" value="Богоявленская">
                </div>
                <button class="btn-green btn-small margin-l10">Ok</button>
            </div>
        </div>
    </div>

    <div class="margin-b20 clearfix">
        <div class="form-settings_label">С Веселым Жирафом</div>
        <div class="form-settings_elem">
            <div class="">
                <span class=""><?= $this->user->withUs() ?></span>
            </div>
        </div>
    </div>

    <div class="margin-b30">Я  хочу <a href="" class="btn-gray-light btn-small margin-5">Удалить анкету </a> , потеряв всю введенную информацию без возможности восстановления. </div>
    <div class="">
        <a href="" class="a-checkbox active"></a>
        Я  хочу получать еженедельные новости от Веселого жирафа.
    </div>
</div>

<script type="text/javascript">
    Array.range= function(a, b, step){
        var A= [];
        if(typeof a== 'number'){
            A[0]= a;
            step= step || 1;
            while(a+step<= b){
                A[A.length]= a+= step;
            }
        }
        else{
            var s= 'abcdefghijklmnopqrstuvwxyz';
            if(a=== a.toUpperCase()){
                b=b.toUpperCase();
                s= s.toUpperCase();
            }
            s= s.substring(s.indexOf(a), s.indexOf(b)+ 1);
            A= s.split('');
        }
        return A;
    }

    function PersonalSettings(data) {
        var self = this;
        self.first_name = new PersonalSettingsAttribute(data.first_name, true);
        self.last_name = new PersonalSettingsAttribute(data.last_name, true);
        self.birthday = new DateWidget(data.birthday);
    }

    function PersonalSettingsAttribute(data, big){
        var self = this;
        self.attribute = ko.observable(data.attribute);
        self.label = ko.observable(data.label);
        self.value = ko.observable(data.value);
        self.newValue = ko.observable(data.value);
        self.editOn = ko.observable(false);
        self.big = ko.observable(big);
        self.error = ko.observable('');

        self.edit = function(){
            self.editOn(true);
        };
        self.isBig = ko.computed(function () {
            return self.big() == true;
        });

        self.save = function() {
            $.post('/user/settings/setValue/', {
                attribute: self.attribute(),
                value: self.newValue()
            }, function(response) {
                if (response.status){
                    self.value(self.newValue());
                    self.editOn(false);
                    self.error('');
                }else{
                    self.error(response.error);
                }
            }, 'json');
        }
    }

    function DateWidget(data){
        var self = this;
        self.monthes = ko.observableArray([
            new DateWidgetMonth(1, 'января'),
            new DateWidgetMonth(2, 'февраля'),
            new DateWidgetMonth(3, 'марта'),
            new DateWidgetMonth(4, 'апреля'),
            new DateWidgetMonth(5, 'мая'),
            new DateWidgetMonth(6, 'июня'),
            new DateWidgetMonth(7, 'июля'),
            new DateWidgetMonth(8, 'августа'),
            new DateWidgetMonth(9, 'сентября'),
            new DateWidgetMonth(10, 'октября'),
            new DateWidgetMonth(11, 'ноября'),
            new DateWidgetMonth(12, 'декабря')
        ]);

        self.attribute = ko.observable(data.attribute);
        self.label = ko.observable(data.label);
        self.editOn = ko.observable(false);
        self.error = ko.observable('');

        self.day = ko.observable(data.day);

        self.getMonthById = function(id){
            var result;
            ko.utils.arrayForEach(this.monthes(), function(month) {
                if (month.id == id)
                    result = month;
            });
            return result;
        };
        self.month = ko.observable(self.getMonthById(data.month));
        self.year = ko.observable(data.year);

        self.selectedDay = ko.observable(data.day);
        self.selectedMonth = ko.observable(data.month);
        self.selectedYear = ko.observable(data.year);

        self.min_year = ko.observable(data.min_year);
        self.max_year = ko.observable(data.max_year);

        self.edit = function(){
            self.editOn(true);
        };
        self.text = ko.computed(function () {
            return self.day() + ' ' + self.month().name + ' ' + self.year() + ' г.';
        });
        self.days = ko.computed(function () {
            return Array.range(1, 31);
        });
        self.years = ko.computed(function () {
            return Array.range(self.min_year(), self.max_year());
        });
        self.newValue = ko.computed(function () {
            console.log(self.selectedMonth());
            return self.selectedYear() + '-' + pad(self.selectedMonth(), 2) + '-' + pad(self.selectedDay(), 2);
        });

        self.save = function() {
            $.post('/user/settings/setValue/', {
                attribute: self.attribute(),
                value: self.newValue()
            }, function(response) {
                if (response.status){
                    self.day(self.selectedDay());
                    self.month(self.getMonthById(self.selectedMonth()));
                    self.year(self.selectedYear());
                    self.editOn(false);
                    self.error('');
                }else{
                    self.error(response.error);
                }
            }, 'json');
        };
    }

    var DateWidgetMonth = function(id, name){
        this.id = id;
        this.name = name;
    }

    function pad (str, max) {
        if (str == undefined)
            return '';
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    vm = new PersonalSettings(<?=CJSON::encode($this->user->getSettingsData())?>);
    $(function() {
        ko.applyBindings(vm, document.getElementById('personal-settings'));
    });
</script>

<script type="text/html" id="attribute-template">
    <div class="margin-b20 clearfix">
        <div class="form-settings_label" data-bind="text: label"></div>
        <div class="form-settings_elem">
            <div data-bind="visible: !editOn()">
                <span data-bind="css: {'form-settings_name': isBig() }, text: value"></span>
                <a href="" class="a-pseudo-icon" data-bind="click: edit">
                    <span class="ico-edit"></span>
                    <span class="a-pseudo-icon_tx">Редактировать</span>
                </a>
            </div>
            <div data-bind="visible: editOn()">
                <div class="float-l w-300">
                    <input type="text" class="itx-gray" data-bind="value: newValue">
                </div>
                <button class="btn-green btn-small margin-l10" data-bind="click: save">Ok</button>
                <!-- ko if: error() != '' -->
                <div class="errorMessage" data-bind="text: error"></div>
                <!-- /ko -->
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="birthday-template">
    <div class="margin-b20 clearfix">
        <div class="form-settings_label" data-bind="text: label"></div>
        <div class="form-settings_elem">
            <div data-bind="visible: !editOn()">
                <span data-bind="text: text"></span>
                <a href="" class="a-pseudo-icon" data-bind="click: edit">
                    <span class="ico-edit"></span>
                    <span class="a-pseudo-icon_tx">Редактировать</span>
                </a>
            </div>
            <div class="clearfix" data-bind="visible: editOn()">
                <div class="w-90 float-l margin-r10">
                    <div class="chzn-gray">
                        <select data-bind="options: days(), value: selectedDay, chosen: {}"></select>
                    </div>
                </div>
                <div class="w-100 float-l margin-r10">
                    <div class="chzn-gray">
                        <select class="chzn" data-bind="options: monthes, optionsText: 'name', optionsValue: 'id', value: selectedMonth, chosen: {}"></select>
                    </div>
                </div>
                <div class="w-90 float-l">
                    <div class="chzn-gray">
                        <select class="chzn" data-bind="options: years, value: selectedYear, chosen: {}"></select>
                    </div>
                </div>
                <button class="btn-green btn-small margin-l10" data-bind="click: save">Ok</button>
            </div>
            <!-- ko if: error() != '' -->
            <div class="errorMessage" data-bind="text: error"></div>
            <!-- /ko -->
        </div>
    </div>
</script>