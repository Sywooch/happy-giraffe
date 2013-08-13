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

<div id="popup-user-add-article" class="b-settings-blue b-settings-blue__article">
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
            </div>
            <?=$form->label($model, 'title', array('class' => 'b-settings-blue_label'))?>
            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Введите заголовок статьи', 'data-bind' => 'value: title, valueUpdate: \'keyup\''))?>
            <?=$form->error($model, 'title')?>
        </div>
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Рубрика</label>
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
                    chosenRubric: {}"></select>
                    <?=$form->error($model, 'rubric_id')?>
                </div>
            </div>
        </div>
    </div>

    <div class="wysiwyg-v wysiwyg-blue clearfix">
        <?=$form->textArea($slaveModel, 'text', array('class' => 'wysiwyg-redactor-v'))?>
        <?=$form->error($slaveModel, 'text')?>

        <!-- ko stopBinding: true -->
        <div class="redactor-popup redactor-popup_b-photo display-n" id="redactor-popup_b-photo">
            <a href="" class="redactor-popup_close ico-close3 powertip" data-bind="click: close"></a>
            <div class="redactor-popup_tale"></div>
            <div class="redactor-popup_t">Загрузите фото</div>

            <?php $this->renderPartial('application.views.upload_image_popup'); ?>

            <div class="textalign-c margin-t15">
                <a href="javascript:;" class="btn-gray-light btn-medium margin-r10" onclick="$(this).parents('.redactor-popup').addClass('display-n');">Отменить</a>
                <a href="" class="btn-green btn-medium" data-bind="click: add, css: {'btn-inactive': !upload().addActive()}">Добавить фото</a>
            </div>
        </div>
        <!-- /ko -->
    </div>

    <div class="clearfix">
        <?=$form->errorSummary(array($model, $slaveModel)) ?>
    </div>

    <div class=" clearfix">
        <button class="btn-blue btn-h46 float-r"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></button>
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

<script>
    var BlogFormPostViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
    }

    formVM = new BlogFormPostViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM, document.getElementById('popup-user-add-article'));
</script>