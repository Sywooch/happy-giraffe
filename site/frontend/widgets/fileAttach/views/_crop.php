<div class="popup" id="photoPick">
    <a onclick="$.fancybox.close();" class="popup-close" href="javascript:void(0);">закрыть</a>
    <div class="title">Настройка главного фото</div>
    <form>
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
                                <div class="img"><img src="<?php echo $src; ?>" id="preview"></div>
                                <div class="note">Так увидят Ваше фото другие посетители сайта</div>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            <div class="form-bottom">
                <button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
                <button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
            </div>
        </div>
    </form>
</div>