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
            <?= $form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Введите заголовок статьи', 'data-bind' => 'value: title, valueUpdate: \'keydown\'')) ?>
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