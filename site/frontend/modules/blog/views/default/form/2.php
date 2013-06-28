<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'blog-form',
    'action' => $model->isNewRecord ? array('save') : array('save', 'id' => $model->id),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>

<div id="popup-user-add-video" class="popup-user-add-record">
    <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">

            <div class="user-add-record user-add-record__yellow clearfix">
                <div class="user-add-record_ava-hold">
                    <a href="" class="ava male">
                        <span class="icon-status status-online"></span>
                        <img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
                    </a>
                </div>
                <div class="user-add-record_hold">
                    <div class="user-add-record_tx">Я хочу добавить</div>
                    <a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
                    <a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
                    <a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video active fancy">Видео</a>
                </div>
            </div>

            <div class="b-settings-blue b-settings-blue__video">
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
                <div class="b-settings-blue_add-video clearfix" data-bind="visible: embed() === null">
                    <?=$form->textField($slaveModel, 'link', array('class' => 'itx-simple w-400 float-l', 'placeholder' => 'Введите ссылку на видео', 'data-bind' => 'value: link, valueUpdate: \'keyup\''))?>
                    <?=$form->error($slaveModel, 'text')?>
                    <button class="btn-green" data-bind="css: { 'btn-inactive' : link().length == 0 }, click: check">Загрузить  видео</button>
                </div>
                <div class="b-settings-blue_video clearfix" data-bind="visible: embed() !== null">
                    <a href="" class="b-settings-blue_video-del ico-close2 powertip" title="Удалить"></a>
                    <div data-bind="html: embed" id="embed"></div>
                </div>
                <div class="b-settings-blue_row clearfix">
                    <textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple" placeholder="Ваш комментарий"></textarea>

                </div>
                <div class=" clearfix">
                    <a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
                    <a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>

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
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    var BlogFormVideoViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
        self.link = ko.observable('');
        self.embed = ko.observable(null);

        self.check = function() {
            $.get('http://www.youtube.com/oembed', { url : self.link(), format : 'json' }, function(data, textStatus) {
                $('#embed').oembed(self.link());
                self.embed($('#embed').html());
            }, 'json');
        }
    }

    formVM = new BlogFormVideoViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM, document.getElementById('popup-user-add-video'));
</script>