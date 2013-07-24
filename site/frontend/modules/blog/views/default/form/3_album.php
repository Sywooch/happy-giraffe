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