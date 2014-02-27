<?php
/**
 * @var AvatarUploadForm $model
 */
?>
<div class="popup-sign_top">
    <div class="popup-sign_title">Главное фото</div>
</div>
<div class="popup-sign_cont popup-sign_cont__wide" data-bind="with: avatar">
    <div class="popup-sign_img-upload">
        <div class="img-upload" data-bind="css: { 'img-upload__uploaded' : imgSrc() !== null }">
            <!-- Блок загрузки изображения-->
            <div class="img-upload_hold">
                <div class="img-upload_top">
                    <div class="img-upload_btn-desc">
                        <div class="img-upload_t">Загрузите фотографию с компьютера</div>
                        <div class="img-upload_help">Поддерживаемые форматы: jpg и png</div>
                    </div>
                    <div class="file-fake">
                        <button class="btn-green-simple btn-m file-fake_btn">Обзор</button>
                        <?=CHtml::activeFileField($model, 'image', array('class' => 'file-fake_inp'))?>
                    </div>
                </div>
                <div class="img-upload_desc">
                    <div class="img-upload_help">Загружайте пожалуйста только свои фотографии</div>
                </div>
            </div>
            <!-- Заглушка при загрузке файла-->
            <div class="img-upload_i-load">
                <!-- ширина для примера, ее нужно считать динамически-->
                <div style="width: 50%;" class="img-upload_i-load-progress"></div>
            </div>
            <!-- Блок обрезки аватара-->
            <?php if (true): ?>
            <div class="img-upload_uploaded">
                <a title="Удалить" class="img-upload_i-del powertip" data-bind="click: clear"></a>
                <img data-bind="jcrop: jcrop, attr: { src : imgSrc }">
            </div>
            <?php else: ?>
            <div class="img-upload_uploaded"><a href="" title="Удалить" class="img-upload_i-del powertip"></a><img id="jcrop_target" src="/new/images/example/w500-h376.jpg">
                <script>
                    jQuery(function($){
                        var api;
                        $('#jcrop_target').Jcrop({
                            // start off with jcrop-light class
                            bgOpacity: 0.6,
                            bgColor: '#2c87c0',
                            addClass: 'jcrop-blue'
                        },function(){
                            api = this;
                            api.setSelect([130,65,130+350,65+285]);
                            api.setOptions({ bgFade: true });
                            api.ui.selection.addClass('jcrop-selection');
                        });
                    });
                </script>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="popup-sign_col-ava popup-sign_col-ava__think">
        <div class="popup-sign_col-ava-t">Просмотр</div>
        <a href="javascript:void(0)" class="ava ava__large ava__female"><span class="ico-status"></span><img alt="" class="ava_img" data-bind="attr: { src : imgSrc }" id="preview-200"/></a>
        <div class="popup-sign_ava-row">
            <a href="javascript:void(0)" class="ava ava__middle ava__female"><span class="ico-status"></span><img alt="" class="ava_img" data-bind="attr: { src : imgSrc }" id="preview-40"/></a>
            <a href="javascript:void(0)" class="ava ava__female"><span class="ico-status"></span><img alt="" class="ava_img" data-bind="attr: { src : imgSrc }" id="preview-72"/></a>
            <a href="javascript:void(0)" class="ava ava__small ava__female"><span class="ico-status"></span><img alt="" class="ava_img" data-bind="attr: { src : imgSrc }" id="preview-24"/></a>
        </div>
        <div class="margin-t5">
            <div class="popup-sign_tx-help">Так будет выглядеть ваше главное фото <br>на страницах Веселого Жирафа</div>
        </div>
    </div>
</div>