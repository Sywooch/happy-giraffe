<?php
     $cs = Yii::app()->clientScript;
     $cssCoreUrl = $cs->getCoreScriptUrl();
     $cs->registerCoreScript('jquery.ui')
     ->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');
?><!-- ko with: location -->
<div class="margin-b20 clearfix">
    <div class="form-settings_label">Место жительства</div>
    <div class="form-settings_elem">
        <div data-bind="visible: !editOn()">
            <div class="location clearfix display-ib verticalalign-m">
                <span class="flag-big" data-bind="attr: {'class': 'flag-big flag-big-' + getFlag() }"></span>
                <span class="location_tx" data-bind="html: text"></span>
            </div>
            <a class="a-pseudo-icon" href="" data-bind="click: function(){editOn(true);}">
                <span class="ico-edit"></span>
                <span class="a-pseudo-icon_tx">Редактировать</span>
            </a>
        </div>

        <div data-bind="visible: editOn()">
            <div class="w-300 margin-b5">
                <div class="chzn-gray">
                    <select class="chzn" data-bind="options: countries, optionsText: 'name', optionsValue: 'id', value: selected_country_id, chosen: {}, event:{ change: CountryChanged}"></select>
                </div>
            </div>
            <div class="w-300 margin-b5" data-bind="visible: regionVisible">
                <div class="chzn-gray">
                    <select class="chzn" data-bind="options: regions, optionsText: 'name', optionsValue: 'id', value: selected_region_id, chosen: {}, optionsCaption: 'Выберите регион', event:{ change: RegionChanged}"></select>
                </div>
            </div>
            <div class="float-l w-300" data-bind="visible: cityVisible">
                <input type="text" class="itx-gray" data-bind="jqAuto: { autoFocus: true },
                jqAutoSource: cities,
                jqAutoQuery: getCities,
                jqAutoValue: selected_city_id,
                jqAutoSourceLabel: 'label',
                jqAutoSourceInputValue: 'label',
                jqAutoSourceValue: 'id'">
            </div>
            <button class="btn-green btn-small margin-l10" data-bind="click: save">Ok</button>
        </div>
    </div>
</div>
<!-- /ko -->