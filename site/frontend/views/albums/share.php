<?php
    $url = $this->createAbsoluteUrl('singlePhoto', array('entity' => 'Album', 'photo_id' => $photo->id, 'valentines' => 1));
?>

<div id="popup-share" class="popup-share popup">
    <div class="popup-share_h">
        Поделиться
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close"><span class="tip">Закрыть</span></a>
    </div>
    <div class="popup-share_hold">
        <div class="margin-b20 clearfix">
            <div class="popup-share_img-preview">
                <?=CHtml::image($photo->getPreviewUrl(95, null, Image::WIDTH))?>
            </div>
            <div class="margin-b10">
                Ссылка
            </div>
            <div class="margin-b10">
                <input type="text" name="" id="" class="popup-share_itx-link itx-bluelight" value="<?=$url?>">
            </div>
        </div>
        <div class="margin-b20">
            <span>Поделиться через</span>
            <ul class="social-list-small">
                <li class="odnoklasniki"><a href="#"></a></li>
                <li class="mailru"><a href="#"></a></li>
                <li class="vkontakte"><a href="#"></a></li>
                <li class="facebook"><a href="#"></a></li>
            </ul>
        </div>

        <div class="margin-b10">
            Отправить по e-mail
        </div>
        <div class="margin-b10">
            <input type="text" name="" id="" class="popup-share_itx itx-bluelight" placeholder="Введите e-mail адресата">
        </div>
        <div class="margin-b10">
            <textarea name="" placeholder="Добавить личное сообщение" class="popup-share_itx itx-bluelight"></textarea>
        </div>
    </div>
    <div class="popup-share_f">
        <a href="" class="btn-green btn-medium">Поделиться</a>
    </div>
</div>