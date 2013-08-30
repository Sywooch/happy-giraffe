<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
?>

<div class="b-settings-blue b-settings-blue__photo"<?php if (!$model->isNewRecord) echo ' style="display:none;"' ?>>
    <div class="b-settings-blue_tale"></div>
    <div class="clearfix">

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Личные <br> фотоальбомы</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img1.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46" onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo').show();">Загрузить фото</a>
            </div>
        </div>

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Фотопост <br> в блоге</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img2.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46" onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo-post').show();">Создать фотопост</a>
            </div>
        </div>

    </div>
</div>

<?php $this->renderPartial('form/3_post', array('json' => $json, 'model' => $model, 'slaveModel' => $slaveModel)); ?>

<?php $this->renderPartial('form/3_album', array('json' => $json)); ?>