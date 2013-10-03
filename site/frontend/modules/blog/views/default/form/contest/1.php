<div id="popup-contest" class="popup-contest popup-contest__pets1">
    <a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'blog-form',
                'action' => $model->isNewRecord ? array('/community/default/save') : array('/community/default/save', 'id' => $model->id),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnType' => true,
                    'validationDelay' => 400,
                ),
            )); ?>
            <?=$form->hiddenField($model, 'type_id')?>
            <div class="b-settings-blue">
                <div class="b-settings-blue_head">
                    <div class="b-settings-blue_row clearfix">
                        <label for="" class="b-settings-blue_label margin-t15">Конкурс</label>
                        <div class="b-settings-blue_row-tx">
                            <div class="heading-title"><?=$contest->title?></div>
                        </div>
                    </div>
                    <div class="b-settings-blue_row clearfix">
                        <div class="clearfix margin-t-10 ">
                            <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
                        </div>
                        <label for="" class="b-settings-blue_label">Заголовок</label>
                        <div class="b-settings-blue_row-tx">
                            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-100p', 'placeholder' => 'Введите заголовок фото', 'data-bind' => 'value: title, valueUpdate: \'keydown\'')) ?>
                            <?=$form->error($model, 'title') ?>
                        </div>
                    </div>
                    <div class="margin-b5 clearfix">
                        <label for="" class="b-settings-blue_label">&nbsp;</label>
                        <div class="b-settings-blue_row-tx">
                            <div class="font-small">
                                Расскажите о своем домашнем животном ( как его зовут, кокой он породы, как вы за ним ухаживаете что он умеет делать, какие лакомства он любит и т д)
                            </div>
                        </div>
                    </div>
                    <div class="b-settings-blue_row clearfix">
                        <label for="" class="b-settings-blue_label">Рассказ</label>
                        <div class="b-settings-blue_row-tx clearfix">
                            <?=$form->textArea($slaveModel, 'text', array('class' => 'b-settings-blue_textarea itx-simple', 'placeholder' => 'Ваш текст', 'cols' => 80, 'rows' => 5)) ?>
                        </div>
                    </div>
                </div>

                <?php $this->renderPartial('application.views.upload_image_popup'); ?>
                <div class="clearfix textalign-r" style="display: none;">
                    <?=$form->hiddenField($slaveModel, 'photos') ?>
                    <?=$form->error($slaveModel, 'photos') ?>
                </div>

                <div class=" clearfix">
                    <button data-bind="click: add, css: { 'btn-inactive': upload().photos().length < 3}" class="btn-blue btn-h46 float-r"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></button>
                    <a href="javascript:void(0)" class="btn-gray-light btn-h46 float-r margin-r15" onclick="$.fancybox.close()">Отменить</a>

                    <div class="float-l margin-t15">
                        <a href="" class="a-checkbox active"></a>
                        <span class="color-gray">Я ознакомлен с</span> <a href="">Правилами конкурса</a>

                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    var PhotoPostViewModel = function (data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
        self.upload = ko.observable(new UploadPhotos(data.photos, true, '#popup-contest'));

        self.add = function () {
            $('#CommunityPhotoPost_photos').val(self.upload().getPhotoIds());
            $('#blog-form').submit();
        }
    };
    var formVM1 = new PhotoPostViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM1, document.getElementById('popup-contest'));
</script>