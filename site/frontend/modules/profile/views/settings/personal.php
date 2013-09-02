<?php
/**
 * @var SettingsController $this
 */
Yii::app()->clientScript->registerScriptFile('/javascripts/ko_settings.js'); ?>
<div id="personal-settings">

    <div data-bind="template: { name: 'attribute-template', data: first_name }"></div>

    <div data-bind="template: { name: 'attribute-template', data: last_name }"></div>

    <div data-bind="template: { name: 'birthday-template', data: birthday}"></div>

    <div class="margin-b20 clearfix">
        <div class="form-settings_label">Пол</div>
        <div class="form-settings_elem">
            <div class="b-radio-icons">
                <input type="radio" name="b-radio2" id="radio4" class="b-radio-icons_radio" value="1" data-bind="checked: IsMale, click: function(){return setGender(1);}">
                <label for="radio4" class="b-radio-icons_label">
                    <span class="ico-male"></span>
                </label>
                <input type="radio" name="b-radio2" id="radio5" class="b-radio-icons_radio" value="0" data-bind="checked: IsMale, click: function(){return setGender(0);}">
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

    <?php $this->renderPartial('_location'); ?>

    <div class="margin-b20 clearfix">
        <div class="form-settings_label">С Веселым Жирафом</div>
        <div class="form-settings_elem">
            <div class="">
                <span class=""><?= $this->user->withUs() ?></span>
            </div>
        </div>
    </div>

    <div class="margin-b30">Я  хочу <?php echo CHtml::link('Удалить анкету ', array('remove'), array('class' => 'btn-gray-light btn-small', 'confirm' => 'Вы действительно хотите удалить анкету?')) ?> , потеряв всю введенную информацию без возможности восстановления.</div>
    <div class="">
        <a href="" class="a-checkbox" data-bind="click: toggleEmails, css: {active: email_subscription() == 1}"></a>
        Я хочу получать еженедельные новости от Веселого Жирафа.
    </div>
</div>

<script type="text/javascript">
    var Settings_vm = null;
    $(function() {
        Settings_vm = new PersonalSettings(<?=CJSON::encode($this->user->getSettingsData())?>);
        ko.applyBindings(Settings_vm, document.getElementById('personal-settings'));
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