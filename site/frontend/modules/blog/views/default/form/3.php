<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
?>
<div class="b-settings-blue b-settings-blue__photo">
    <div class="b-settings-blue_tale"></div>
    <div class="clearfix">

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Личные <br> фотоальбомы</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img1.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46"
                   onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo').show();">Загрузить
                    фото</a>
            </div>
        </div>

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Фотопост <br> в блоге</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img2.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46"
                   onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo-post').show();">Создать
                    фотопост</a>
            </div>
        </div>

    </div>
</div>

<div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo-post" style="display: none;">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'blog-form',
        'action' => $model->isNewRecord ? array('save') : array('save', 'id' => $model->id),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3">0/50</div>
            </div>
            <?= $form->label($model, 'title', array('class' => 'b-settings-blue_label')) ?>
            <?= $form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Введите заголовок статьи', 'data-bind' => 'value: title, valueUpdate: \'keyup\'')) ?>
            <?= $form->error($model, 'title') ?>
        </div>
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Рубрика</label>

            <div class="w-400 float-l">
                <div class="chzn-itx-simple">
                    <?= $form->dropDownList($model, 'rubric_id', CHtml::listData($this->user->blog_rubrics, 'id', 'title'), array('class' => 'chzn')) ?>
                    <?= $form->error($model, 'rubric_id') ?>
                </div>
            </div>
        </div>
    </div>


    <!-- .dragover - класс добавлять, когда курсер мыши с файлами находится над блоком -->
    <div class="b-add-img b-add-img__for-multi">
        <div class="b-add-img_hold">
            <div class="b-add-img_t">
                Загрузите фотографии с компьютера
                <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
            </div>
            <div class="file-fake">
                <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                <input type="file" class="js-upload-files-multiple" multiple/>
            </div>
        </div>

        <div class="textalign-c clearfix">
            <!-- ko with: upload -->
            <!-- ko foreach: photos -->
            <div class="b-add-img_i" data-bind="attr: {id: 'uploaded_photo_' + uid}">
                <div class="js-image" style="opacity: 0.2"></div>
                <div class="b-add-img_i-vert"></div>
                <div class="b-add-img_i-load">
                    <div class="b-add-img_i-load-progress" data-bind="style: {width: progress}"></div>
                </div>
                <div class="b-add-img_i-overlay">
                    <a href="" class="b-add-img_i-del ico-close4" data-bind="click: remove"></a>
                </div>
            </div>
            <!-- /ko -->
            <!-- /ko -->
        </div>

        <!-- ko if: upload().photos().length == 0 -->
        <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
        <!-- /ko -->
    </div>

    <div class="b-settings-blue_row clearfix">
        <textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple"
                  placeholder="Ваш текст к фотопосту "></textarea>
    </div>
    <div class=" clearfix">
        <a href="" class="btn-blue btn-h46 float-r" data-bind="click: add, css: {'btn-inactive': upload().photos().length == 0}">Добавить</a>
        <a href="" class="btn-gray-light btn-h46 float-r margin-r15"
           onclick="$.fancybox.close();return false;">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">
                <?= $form->hiddenField($model, 'privacy', array('data-bind' => 'value: selectedPrivacyOption().value()')) ?>
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


<div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo" style="display: none;">
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Фотоальбом</label>

            <div class="w-400 float-l">
                <div class="chzn-itx-simple">
                    <?= CHtml::dropDownList('album_id', '', CHtml::listData(Album::model()->findAllByAttributes(array('author_id' => Yii::app()->user->id, 'type' => 0)), 'id', 'title'), array('class' => 'chzn', 'data-bind' => 'value:id')) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="b-add-img b-add-img__multi">
        <div class="b-add-img_hold">
            <div class="b-add-img_t">
                Загрузите фотографии с компьютера
                <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
            </div>
            <div class="file-fake">
                <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                <input type="file" class="js-upload-files-multiple" multiple/>
            </div>
        </div>
        <div class="textalign-c clearfix">
            <!-- ko with: upload -->
            <!-- ko foreach: photos -->
            <div class="b-add-img_i" data-bind="attr: {id: 'uploaded_photo_' + uid}">
                <div class="js-image" style="opacity: 0.2"></div>
                <div class="b-add-img_i-vert"></div>
                <div class="b-add-img_i-load">
                    <div class="b-add-img_i-load-progress" data-bind="style: {width: progress}"></div>
                </div>
                <div class="b-add-img_i-overlay">
                    <a href="" class="b-add-img_i-del ico-close4" data-bind="click: remove"></a>
                </div>
            </div>
            <!-- /ko -->
            <!-- /ko -->
        </div>

        <!-- ko if: upload().photos().length == 0 -->
        <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
        <!-- /ko -->
    </div>

    <div class=" clearfix">
        <a href="" class="btn-blue btn-h46 float-r" data-bind="click: add, css: {'btn-inactive': upload().photos().length == 0}">Добавить</a>
        <a href="javascript:;" class="btn-gray-light btn-h46 float-r margin-r15"
           onclick="$.fancybox.close()">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        var PhotoPostViewModel = function (data) {
            var self = this;
            ko.utils.extend(self, new BlogFormViewModel(data));
            self.upload = ko.observable(new UploadPhotos());

            self.add = function () {
                if (self.upload().photos().length > 0)
                    var a = 0;
            }
        };
        var formVM1 = new PhotoPostViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(formVM1, document.getElementById('popup-user-add-photo-post'));

        var PhotoAlbumViewModel = function () {
            var self = this;
            self.id = 0;
            self.upload = ko.observable(new UploadPhotos());

            self.add = function () {
                if (self.upload().photos().length > 0){
                    var photo_ids = [];
                    var a = self.upload().photos();
                    for (var i = 0; i < a.length; i++){
                        photo_ids.push(a[i].id());
                    }

                    console.log(photo_ids);
                    $.post('/ajaxSimple/addPhoto/', {album_id: self.id, photo_ids: photo_ids}, function (response) {
                        if (response.status)
                            $.fancybox.close();
                    }, 'json');
                }
            }
        };
        var formVM2 = new PhotoAlbumViewModel();
        ko.applyBindings(formVM2, document.getElementById('popup-user-add-photo'));


        if (!(FileAPI.support.cors || FileAPI.support.flash)) {
            $('#oooops').show();
            $('#buttons-panel').hide();
        }

        if (FileAPI.support.dnd) {
            $('.b-add-img_html5-tx').show();

            $(document).dnd(function (over) {
            }, function (files) {
                formVM1.upload().onFiles(files);
                formVM2.upload().onFiles(files);
            });
        }

        $('#popup-user-add-photo .js-upload-files-multiple').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            formVM2.upload().onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });
        $('#popup-user-add-photo-post .js-upload-files-multiple').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            formVM1.upload().onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });
    });
</script>