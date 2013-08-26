<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
?>

<?php $this->renderPartial('form/script'); ?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'blog-form',
    'action' => $model->isNewRecord ? array('save') : array('save', 'id' => $model->id),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>

<?=$form->hiddenField($model, 'type_id')?>

<div id="popup-user-add-video" class="b-settings-blue b-settings-blue__video">
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
            </div>
            <?=$form->label($model, 'title', array('class' => 'b-settings-blue_label'))?>
            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Придумайте заголовок', 'data-bind' => 'value: title, valueUpdate: \'keyup\''))?>
            <?=$form->error($model, 'title')?>
        </div>
        <div class="b-settings-blue_row clearfix">
            <?=$form->label($model, 'rubric_id', array('class' => 'b-settings-blue_label'))?>
            <div class="w-400 float-l">
                <div class="chzn-itx-simple js-select-rubric">
                    <select name="<?=CHtml::activeName($model, 'rubric_id')?>" id="<?=CHtml::activeId($model, 'rubric_id')?>" data-bind="options: rubricsList,
                    value: selectedRubric,
                    optionsText: function(rubric) {
                        return rubric.title;
                    },
                    optionsValue: function(rubric) {
                        return rubric.id;
                    },
                    chosenRubric: {}" data-placeholder="Выберите рубрику или создайте новую"></select>
                    <?=$form->error($model, 'rubric_id')?>
                </div>
            </div>
        </div>
    </div>
    <!-- ko with: video -->
    <div class="b-settings-blue_add-video clearfix" data-bind="visible: embed() === null">
        <?=$form->textField($slaveModel, 'link', array('class' => 'itx-simple w-400 float-l', 'placeholder' => 'Введите ссылку на видео', 'data-bind' => 'value: link, valueUpdate: \'keyup\''))?>
        <button class="btn-green" data-bind="css: { 'btn-inactive' : link().length == 0 }, click: check">Загрузить  видео</button>
        <div class="b-settings-blue_add-video-load" data-bind="visible: previewLoading">
            <img src="/images/ico/ajax-loader.gif" alt=""> <br>
            Подждите видео загружается
        </div>
        <?=$form->error($slaveModel, 'link')?>
    </div>
    <div class="b-settings-blue_video clearfix" data-bind="visible: embed() !== null">
        <a class="b-settings-blue_video-del ico-close2 powertip" title="Удалить" data-bind="click: remove"></a>
        <div data-bind="html: embed" id="embed"></div>
    </div>
    <!-- /ko -->
    <div class="b-settings-blue_row clearfix">
        <?=$form->textArea($slaveModel, 'text', array('cols' => 80, 'rows' => 5, 'class' => 'b-settings-blue_textarea itx-simple', 'placeholder' => 'Ваш комментарий'))?>
        <?=$form->error($slaveModel, 'text')?>
    </div>
    <div class="clearfix">
        <button class="btn-blue btn-h46 float-r btn-inactive"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></button>
        <a href="javascript:void(0)" onclick="$.fancybox.close()" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">
                <?=$form->hiddenField($model, 'privacy', array('data-bind' => 'value: selectedPrivacyOption().value()'))?>
                <div class="privacy-select_hold clearfix">
                    <div class="privacy-select_tx">Для кого:</div>
                    <div class="privacy-select_drop-hold">
                        <a class="privacy-select_a" data-bind="click: $root.toggleDropdown, with: selectedPrivacyOption()">
                            <span class="ico-users active" data-bind="css: 'ico-users__' + cssClass()"></span>
                            <span class="privacy-select_a-tx" data-bind="html: title"></span>
                        </a>
                    </div>
                    <div class="privacy-select_drop" data-bind="css: { 'display-b' : showDropdown}">
                        <!-- ko foreach: privacyOptions -->
                        <div class="privacy-select_i">
                            <a class="privacy-select_a" data-bind="click: select">
                                <span class="ico-users" data-bind="css: 'ico-users__' + cssClass()"></span>
                                <span class="privacy-select_a-tx" data-bind="html: title"></span>
                            </a>
                        </div>
                        <!-- /ko -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var BlogFormVideoViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
        self.video = new Video(data, self);
    }

    formVM = new BlogFormVideoViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM, document.getElementById('popup-user-add-video'));
</script>