<?php
/**
 * @var PhotoController $this
 * @var $json
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('photoAlbumsView', array('ko' => 'knockout', 'MyPhotosAlbumViewModel' => 'photo/MyPhotosAlbumViewModel'), "ko.applyBindings(new MyPhotosAlbumViewModel($json), document.getElementById('photoAlbumsView'));");
?>

<div class="page-col_cont page-col_cont__in" id="photoAlbumsView" data-bind="visible: true" style="display: none;">
    <div class="user-album">
        <div class="b-crumbs b-crumbs__m">
            <ul class="b-crumbs_ul">
                <li class="b-crumbs_li"><a href="" class="b-crumbs_a">Мои фото</a></li>
                <li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last"> Харьковский уикенд</span></li>
            </ul>
        </div>
        <div class="user-album_top clearfix">
            <!-- Счетчик серого цвета из-за .user-album_count-hold__gray-->
            <div class="user-album_count-hold user-album_count-hold__gray">
                <div class="user-album_count" data-bind="text: album.photoCollection().attachesCount()"></div>
                <div class="user-album_count-tx">фото</div>
            </div>
            <!-- Заголовок-->
            <div class="user-album_switch" data-bind="visible: editingHeader() === false">
                <h1 class="user-album_t"><span data-bind="text: album.title()"></span><a class="ico-edit ico-edit__s" data-bind="click: editHeader"></a></h1>
            </div>
            <!-- Редактирование заголовка-->
            <div class="user-album_switch" data-bind="visible: editingHeader() !== false">
                <div class="user-album_t">
                    <div class="display-ib w-400">
                        <div class="inp-valid inp-valid__abs">
                            <input type="text" value="Виктория" class="itx-gray" data-bind="value: editingHeader">
                            <div class="inp-valid_count">150</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-album_desc">
                <div class="user-album_switch">В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер.<a class="ico-edit ico-edit__s"></a></div>
                <!-- Блок редактирвоания описания-->
                <div class="user-album_switch display-n">
                    <!-- Отправка значения происходит по enter-->
                    <textarea rows="8" cols="40" class="itx-gray">В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер. </textarea>
                </div>
            </div>
        </div>
        <div class="user-album_control clearfix"><a href="" class="user-album_del">Удалить альбом</a></div>
        <div class="album-photo-add album-photo-add__big">
            <div class="album-photo-add_hold">Загрузить <br>фото в альбом</div>
        </div>
    </div>
</div>