<div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo-post"<?php if ($model->isNewRecord) echo ' style="display:none;"' ?>>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'blog-form',
        'action' => $model->isNewRecord ? array('save') : array('save', 'id' => $model->id),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => new CJavaScriptExpression('js:function(form, data, hasError) {
                formVM1.hasError(hasError);
                return ! hasError;
            }'),
        ),
    )); ?>

    <?=$form->hiddenField($model, 'type_id')?>

    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
            </div>
            <?=$form->label($model, 'title', array('class' => 'b-settings-blue_label')) ?>
            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Введите заголовок статьи', 'data-bind' => 'value: title, valueUpdate: \'keydown\'')) ?>
            <?=$form->error($model, 'title') ?>
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
                    chosenRubric: {}" data-placeholder="Выберите рубрику или создайте новую"></select>
                    <?=$form->error($model, 'rubric_id')?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->renderPartial('application.views.upload_image_popup'); ?>

    <div class="b-settings-blue_row clearfix">
        <?=$form->textArea($slaveModel, 'text', array('class' => 'b-settings-blue_textarea itx-simple', 'placeholder'=>"Ваш текст к фотопосту", 'cols'=>80, 'rows'=>5)) ?>
    </div>
    <?=$form->hiddenField($slaveModel, 'photos') ?>
    <div class="clearfix">
        <?=$form->errorSummary(array($model, $slaveModel)) ?>
    </div>
    <div class=" clearfix">
        <button class="btn-blue btn-h46 float-r btn-inactive" data-bind="click: add, css: { 'btn-inactive': upload().photos().length < 3 || hasError() }"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></button>
        <a href="" class="btn-gray-light btn-h46 float-r margin-r15" onclick="$.fancybox.close();return false;">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">
                <?=$form->hiddenField($model, 'privacy', array('data-bind' => 'value: selectedPrivacyOption().value()')) ?>
                <div class="privacy-select_hold clearfix">
                    <div class="privacy-select_tx">Для кого:</div>
                    <div class="privacy-select_drop-hold">
                        <a class="privacy-select_a"
                           data-bind="click: $root.toggleDropdown, with: selectedPrivacyOption()">
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

    <?php $this->endWidget(); ?>

</div>
<script type="text/javascript">
    $('#CommunityPhotoPost_text').redactorHG({
        minHeight: 80,
        autoresize: true,
        buttons: []
    });

    var PhotoPostViewModel = function (data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
        self.upload = ko.observable(new UploadPhotos(data.photos, true, '#popup-user-add-photo-post'));

        self.add = function () {
            $('#CommunityPhotoPost_photos').val(self.upload().getPhotoIds());

            if (self.upload().photos().length > 2){
                $('#blog-form').submit();
            }else{
                alert('Минимум 3 фото')
            }
        }
    };
    var formVM1 = new PhotoPostViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM1, document.getElementById('popup-user-add-photo-post'));
</script>