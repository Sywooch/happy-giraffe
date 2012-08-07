<div class="popup" id="photoPick">
    <a onclick="$.fancybox.close();" class="popup-close" href="javascript:void(0);">закрыть</a>
    <div class="title">Настройка главного фото</div>
    <form id="crop_form" onsubmit="return <?php echo $widget_id; ?>.changeAvatar(this);">
        <div class="form">
            <div class="photo-crop clearfix">
                <div class="note">Выберите область на основной фотографии, которая будет<br>отображаться в трех вариантах на сайте</div>
                <div class="clearfix">
                    <table>
                        <tbody><tr>
                            <td class="crop">
                                <img width="300" src="<?php echo $src; ?>" id="crop_target">
                            </td>
                            <td class="preview">
                                <div class="img"><img src="<?php echo $src; ?>" id="preview" style="max-width: none !important;"></div>
                                <div class="note">Так увидят Ваше фото другие посетители сайта</div>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            <input type="hidden" id="coords_value" name="coords" value="" />
            <input type="hidden" name="val" value="<?php echo $val; ?>" />
            <div class="form-bottom" style="display:none;">
                <button class="btn btn-gray-medium" onclick="$.fancybox.close();return false;"><span><span>Отменить</span></span></button>
                <button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
            </div>
        </div>
    </form>
</div>