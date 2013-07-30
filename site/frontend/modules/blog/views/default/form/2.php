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
            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Введите заголовок статьи', 'data-bind' => 'value: title, valueUpdate: \'keyup\''))?>
            <?=$form->error($model, 'title')?>
        </div>
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Рубрика</label>
            <div class="w-400 float-l">
                <div class="chzn-itx-simple">
                    <?=$form->dropDownList($model, 'rubric_id', CHtml::listData($this->user->blog_rubrics, 'id', 'title'), array('class' => 'chzn'))?>
                    <?=$form->error($model, 'rubric_id')?>
                    <div class="chzn-itx-simple_add">
                        <div class="chzn-itx-simple_add-hold">
                            <input type="text" name="" id="" class="chzn-itx-simple_add-itx">
                            <a href="" class="chzn-itx-simple_add-del"></a>
                        </div>
                        <button class="btn-green">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ko with: video -->
    <div class="b-settings-blue_add-video clearfix" data-bind="visible: embed() === null">
        <?=$form->textField($slaveModel, 'link', array('class' => 'itx-simple w-400 float-l', 'placeholder' => 'Введите ссылку на видео', 'data-bind' => 'value: link, valueUpdate: \'keyup\''))?>
        <?=$form->error($slaveModel, 'text')?>
        <button class="btn-green" data-bind="css: { 'btn-inactive' : link().length == 0 }, click: check">Загрузить  видео</button>
        <div class="b-settings-blue_add-video-load" data-bind="visible: previewLoading">
            <img src="/images/ico/ajax-loader.gif" alt=""> <br>
            Подждите видео загружается
        </div>
        <div class="b-settings-blue_add-video-error" data-bind="visible: previewError">
            Не удалось загрузить видео. <br>
            Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.
        </div>
    </div>
    <div class="b-settings-blue_video clearfix" data-bind="visible: embed() !== null">
        <a class="b-settings-blue_video-del ico-close2 powertip" title="Удалить" data-bind="click: remove"></a>
        <div data-bind="html: embed" id="embed"></div>
    </div>
    <!-- /ko -->
    <div class="b-settings-blue_row clearfix">
        <?=$form->textArea($slaveModel, 'text', array('cols' => 80, 'rows' => 5, 'class' => 'b-settings-blue_textarea itx-simple', 'placeholder' => 'Ваш комментарий'))?>

    </div>
    <div class=" clearfix">
        <a href="javascript:void(0)" onclick="$('#blog-form').submit()" class="btn-blue btn-h46 float-r btn-inactive"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></a>
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
    var BlogFormVideoViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
        self.video = new Video(data, self);
    }

    formVM = new BlogFormVideoViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM, document.getElementById('popup-user-add-video'));
</script>