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
            <div class="user-album_count-hold">
                <div class="user-album_count" data-bind="text: album.photoCollection().attachesCount(), css: { 'user-album_count-hold__gray' : album.photoCollection().attachesCount() == 0 }"></div>
                <div class="user-album_count-tx">фото</div>
            </div>
            <!-- Заголовок-->
            <div class="user-album_switch" data-bind="visible: editingTitle() === false">
                <h1 class="user-album_t"><span data-bind="text: album.title()"></span><a class="ico-edit ico-edit__s" data-bind="click: editTitle"></a></h1>
            </div>
            <!-- Редактирование заголовка-->
            <div class="user-album_switch" data-bind="visible: editingTitle() !== false">
                <div class="user-album_t">
                    <div class="display-ib w-400">
                        <div class="inp-valid inp-valid__abs">
                            <input type="text" value="Виктория" class="itx-gray" data-bind="value: editingTitle, event: { blur: saveTitle }, hasFocus: editingTitle() !== false">
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
        <div class="user-album_control clearfix">
            <a href="" class="user-album_del" data-bind="click: removeAlbum">Удалить альбом</a>
            <!-- ko if: album.photoCollection().attachesCount() > 0 -->
                <a href="" class="user-album_sort" data-bind="click: sort">Упорядочить фото</a>
                <a href="" class="user-album_move">Переместить в другой альбом</a>
            <!-- /ko -->
        </div>

        <!-- ko if: album.photoCollection().attachesCount() == 0 -->
        <div class="album-photo-add album-photo-add__big">
            <div class="album-photo-add_hold" data-bind="photoUpload: { data: { multiple: true, collectionId: album.photoCollection().id() }, observable: album.photoCollection().attaches }">Загрузить <br>фото в альбом</div>
        </div>
        <!-- /ko -->

        <!-- ko if: mode() == MODE_SORT -->
        <div class="i-info">Перетаскивайте фото мышкой</div>
        <div class="user-album_control clearfix">
            <!-- Для фиксации элемента при скролле нужен new/javascript/bootstrap/affix.js-->
            <!-- инициализация i-affix в common-markup.js-->
            <div class="i-affix clearfix">
                <div class="float-r">
                    <div class="btn btn-green btn-ms" data-bind="click: saveSort">Готово</div>
                    <div class="btn btn-link btn-link-gray btn-ms">Отмена</div>
                </div>
            </div>
        </div>
        <!-- Список альбомов
        .album-preview__s
        .album-preview__m
        .album-preview__xl
        -->
        <div class="album-preview album-preview__m album-preview__drag">
            <ul class="album-preview_ul" data-bind="foreach: album.photoCollection().attaches, sortable: {}">
                <li class="album-preview_li">
                    <a href="" class="album-preview_in">
                        <div class="album-preview_img-hold">
                            <img src="" alt="" class="album-preview_img" data-bind="thumb: { photo: $data.photo(), preset: 'uploadPreview' }">
                        </div>
                        <div class="album-preview_overlay"></div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /ko -->

        <div class="img-grid" style="display: none;">
            <!-- Что б изображения не падали, последний элемент может выступать до 5 пк за рамку, эти пиксели обрежуться.-->
            <!-- Ряд изображений-->
            <div class="img-grid_row clearfix">
                <!-- Нужно выставить высоту и ширину блоку, что б получалася полный ряд-->
                <div style="width: 280px; height: 380px;" class="img-grid_i">
                    <div class="album-photo-add album-photo-add__m">
                        <div class="album-photo-add_hold">Загрузить еще<br>фото в альбом</div>
                    </div>
                </div>
                <div class="img-grid_i">
                    <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w280-h370-3.jpg" alt="" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                        <div class="img-grid_ico-ava active"></div>
                        <div class="img-grid_ico-album active"></div>
                        <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                    </div>
                </div>
                <div class="img-grid_i">
                    <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w280-h370-1.jpg" alt="" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                        <div class="img-grid_ico-ava"></div>
                        <div class="img-grid_ico-album"></div>
                        <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                    </div>
                </div>
            </div>
            <!-- Ряд изображений-->
            <div class="img-grid_row clearfix">
                <div class="img-grid_i">
                    <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w305-h360-1.jpg" alt="" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                        <div class="img-grid_ico-ava"></div>
                        <div class="img-grid_ico-album"></div>
                        <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                    </div>
                </div>
                <div class="img-grid_i">
                    <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w558-h360-1.jpg" alt="" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                        <div class="img-grid_ico-ava"></div>
                        <div class="img-grid_ico-album"></div>
                        <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                    </div>
                </div>
            </div>
            <!-- Ряд изображений-->
            <div class="img-grid_row clearfix">
                <div class="img-grid_i img-grid_i__del">
                    <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w280-h370-1.jpg" alt="" class="img-grid_img">
                    <!-- Заглушка удаленной фото-->
                    <!-- cap-empty-->
                    <div class="cap-empty cap-empty__abs cap-empty__white">
                        <div class="cap-empty_hold">
                            <div class="cap-empty_img"></div>
                            <div class="cap-empty_t">Фотография удалена </div>
                            <div class="cap-empty_tx"><a href=''>Восстановить</a></div>
                        </div>
                        <div class="verticalalign-m-help"></div>
                    </div>
                    <!-- /cap-empty-->
                </div>
                <div class="img-grid_i">
                    <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w280-h370-2.jpg" alt="" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                        <div class="img-grid_ico-ava"></div>
                        <div class="img-grid_ico-album"></div>
                        <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                    </div>
                </div>
                <div class="img-grid_i">
                    <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w280-h370-3.jpg" alt="" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                        <div class="img-grid_ico-ava"></div>
                        <div class="img-grid_ico-album"></div>
                        <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                    </div>
                </div>
            </div>
            <!-- Ряд изображений-->
            <div class="img-grid_row clearfix">
                <!-- При отложенной загрузке изображений на .img-grid_i нужно высталять ширину и высоту изображения.-->
                <!-- До момента загрузки/показа изображения на .img-grid_i ставить класс .loading, затем убирать. -->
                <div class="img-grid_i loading"><img src="#" alt="" width="160" height="260" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
                    <!-- Блок процесса загрузки фото-->
                    <!-- Цвета
                    img-grid_loading__purple
                    img-grid_loading__yellow
                    img-grid_loading__carrot
                    img-grid_loading__green
                    img-grid_loading__blue
                    -->
                    <div class="img-grid_loading img-grid_loading__purple">
                        <div class="img-grid_loading-hold">
                            <div class="css-progress css-progress__xl">
                            </div>
                            <div class="img-grid_loading-tx">Загрузка фотографии</div>
                        </div>
                    </div>
                </div>
                <!-- При отложенной загрузке изображений на .img-grid_i нужно высталять ширину и высоту изображения.-->
                <!-- До момента загрузки/показа изображения на .img-grid_i ставить класс .loading, затем убирать. -->
                <div class="img-grid_i loading"><img src="#" alt="" width="160" height="260" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
                    <!-- Блок процесса загрузки фото-->
                    <!-- Цвета
                    img-grid_loading__purple
                    img-grid_loading__yellow
                    img-grid_loading__carrot
                    img-grid_loading__green
                    img-grid_loading__blue
                    -->
                    <div class="img-grid_loading img-grid_loading__yellow">
                        <div class="img-grid_loading-hold">
                            <div class="css-progress css-progress__xl">
                            </div>
                            <div class="img-grid_loading-tx">Загрузка фотографии</div>
                        </div>
                    </div>
                </div>
                <!-- При отложенной загрузке изображений на .img-grid_i нужно высталять ширину и высоту изображения.-->
                <!-- До момента загрузки/показа изображения на .img-grid_i ставить класс .loading, затем убирать. -->
                <div class="img-grid_i loading"><img src="#" alt="" width="160" height="260" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
                    <!-- Блок процесса загрузки фото-->
                    <!-- Цвета
                    img-grid_loading__purple
                    img-grid_loading__yellow
                    img-grid_loading__carrot
                    img-grid_loading__green
                    img-grid_loading__blue
                    -->
                    <div class="img-grid_loading img-grid_loading__carrot">
                        <div class="img-grid_loading-hold">
                            <div class="css-progress css-progress__xl">
                            </div>
                            <div class="img-grid_loading-tx">Загрузка фотографии</div>
                        </div>
                    </div>
                </div>
                <!-- При отложенной загрузке изображений на .img-grid_i нужно высталять ширину и высоту изображения.-->
                <!-- До момента загрузки/показа изображения на .img-grid_i ставить класс .loading, затем убирать. -->
                <div class="img-grid_i loading"><img src="#" alt="" width="160" height="260" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
                    <!-- Блок процесса загрузки фото-->
                    <!-- Цвета
                    img-grid_loading__purple
                    img-grid_loading__yellow
                    img-grid_loading__carrot
                    img-grid_loading__green
                    img-grid_loading__blue
                    -->
                    <div class="img-grid_loading img-grid_loading__green">
                        <div class="img-grid_loading-hold">
                            <div class="css-progress css-progress__xl">
                            </div>
                            <div class="img-grid_loading-tx">Загрузка фотографии</div>
                        </div>
                    </div>
                </div>
                <!-- При отложенной загрузке изображений на .img-grid_i нужно высталять ширину и высоту изображения.-->
                <!-- До момента загрузки/показа изображения на .img-grid_i ставить класс .loading, затем убирать. -->
                <div class="img-grid_i loading"><img src="#" alt="" width="160" height="260" class="img-grid_img">
                    <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
                    <!-- Блок процесса загрузки фото-->
                    <!-- Цвета
                    img-grid_loading__purple
                    img-grid_loading__yellow
                    img-grid_loading__carrot
                    img-grid_loading__green
                    img-grid_loading__blue
                    -->
                    <div class="img-grid_loading img-grid_loading__blue">
                        <div class="img-grid_loading-hold">
                            <div class="css-progress css-progress__xl">
                            </div>
                            <div class="img-grid_loading-tx">Загрузка фотографии</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>