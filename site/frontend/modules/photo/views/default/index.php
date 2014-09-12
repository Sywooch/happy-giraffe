<?php
/**
 * @var PhotoController $this
 * @var $json
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('myPhotos', array('ko' => 'knockout', 'MyPhotos' => 'photo/myPhotos'), "vvm = new MyPhotos($json); ko.applyBindings(vvm, document.getElementById('myPhotos'))");
?>

<div class="page-col_cont page-col_cont__in" id="myPhotos">
    <!-- userAddRecord-->
    <div class="userAddRecord clearfix userAddRecord__blog userAddRecord__blog">
        <div class="userAddRecord_hold">
            <div class="userAddRecord_tx">Я хочу добавить
            </div><a href="" data-theme="transparent" class="userAddRecord_i">
                <div class="userAddRecord_ico userAddRecord_ico__photo-add fancy"></div>
                <div class="userAddRecord_desc">Фотографии <br> без альбома</div></a><a href="" data-theme="transparent" class="userAddRecord_i fancy">
                <div class="userAddRecord_ico userAddRecord_ico__album"></div>
                <div class="userAddRecord_desc">Новый <br> фотоальбом</div></a>
        </div>
    </div>
    <!-- /userAddRecord-->
    <!-- ko foreach: nonEmptyAlbums -->
        <section class="b-album"><a href="" class="b-album_img-hold">
                <!-- Высота изображений 580 пк-->
                <!-- Если изображения маленькие, они становятся по центру--><img src="" alt="" class="b-album_img-big" data-bind="thumb: { photo : photoCollection().cover(), preset : 'myPhotosAlbumCover' }">
                <div class="b-album_img-hold-ovr">
                    <div class="ico-zoom ico-zoom__abs"></div>
                </div></a>
            <div class="b-album_top">
                <div class="tx-date">Обновлен  Вчера 13:45</div>
                <h2 class="b-album_title"><a href="" class="b-album_title-a" data-bind="text: title"></a></h2>
                <!-- 2 строки описания, предположительно 140 символов--><a href="" class="b-album_desc" data-bind="text: description"></a>
                <div class="b-album_count-hold">
                    <div class="b-album_count" data-bind="text: photoCollection().attachesCount()"></div>
                    <div class="b-album_count-tx">фото</div>
                </div>
            </div>
            <div class="b-album_overlay"><a class="b-album_r">
                    <div class="b-album_tx">Смотреть  <br> все фото &nbsp;
                    </div>
                    <div class="b-album_ico-album"></div>
                    <div class="b-album_arrow"></div></a>
                <ul class="b-album_prev clearfix">
                    <!-- Нужно уточнить какую ширину должен занимать ряд изображений или какое их количество будет. Предполагаю, что 5шт в ряду.-->
                    <li class="b-album_prev-li"><a href="" class="b-album_prev-a"><img src="/new/images/example/w104-h70-1.jpg" alt="" class="b-album_prev-img">
                            <div class="b-album_prev-hold"></div></a></li>
                    <li class="b-album_prev-li"><a href="" class="b-album_prev-a"><img src="/new/images/example/w46-h70-1.jpg" alt="" class="b-album_prev-img">
                            <div class="b-album_prev-hold"></div></a></li>
                    <li class="b-album_prev-li"><a href="" class="b-album_prev-a"><img src="/new/images/example/w104-h70-2.jpg" alt="" class="b-album_prev-img">
                            <div class="b-album_prev-hold"></div></a></li>
                    <li class="b-album_prev-li"><a href="" class="b-album_prev-a"><img src="/new/images/example/w104-h70-1.jpg" alt="" class="b-album_prev-img">
                            <div class="b-album_prev-hold"></div></a></li>
                    <li class="b-album_prev-li"><a href="" class="b-album_prev-a"><img src="/new/images/example/w104-h70-2.jpg" alt="" class="b-album_prev-img">
                            <div class="b-album_prev-hold"></div></a></li>
                    <li class="b-album_prev-li"><a href="" class="album-photo-add"></a></li>
                </ul>
            </div>
        </section>
    <!-- /ko -->
    <!-- ko if: emptyAlbums().length > 0 -->
        <div class="heading-small margin-t40">Альбомы без фотографий</div>

        <!-- ko foreach: emptyAlbums -->
            <div class="album-empty">
                <div class="album-empty_hold">
                    <a href="" class="album-empty_t" data-bind="text: title"></a>
                    <a href="" class="album-empty_desc" data-bind="text: description"></a>
                </div>
                <a href="" class="album-photo-add"></a>
                <a href="" class="album-empty_del" data-bind="click: $root.removeAlbum"></a>
                <div class="album-empty_count" data-bind="text: photoCollection().attachesCount()"></div>
            </div>
        <!-- /ko -->
    <!-- /ko -->
    <div class="heading-small margin-t60">Последние добавленные фото
        <div class="float-r">
            <div class="btn btn-link btn-link-gray btn-s">Фото вне альбомов 28</div>
            <div class="btn btn-link btn-link-gray btn-s">Все фотографии 628</div>
        </div>
    </div>
    <!-- img-grid-->
    <div class="img-grid">
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
                    <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                </div>
            </div>
            <div class="img-grid_i">
                <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w280-h370-1.jpg" alt="" class="img-grid_img">
                <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                    <div class="img-grid_ico-ava"></div>
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
                    <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                </div>
            </div>
            <div class="img-grid_i">
                <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w558-h360-1.jpg" alt="" class="img-grid_img">
                <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                    <div class="img-grid_ico-ava"></div>
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
                    <div class="img-grid_overlay-b"><a href="" title="Удалить фото" class="ico-trash powertip"></a><a href="" title="Редактировать" class="ico-photo-edit powertip"></a><a href="" title="Переместить" class="ico-move powertip"></a></div>
                </div>
            </div>
            <div class="img-grid_i">
                <!-- Высота изображений может отличаться в зависимости от ряда--><img src="/new/images/example/w280-h370-3.jpg" alt="" class="img-grid_img">
                <div class="img-grid_overlay"><span class="ico-zoom ico-zoom__abs"></span>
                    <div class="img-grid_ico-ava"></div>
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
    <div class="i-allphoto"><a href="" class="i-allphoto_a">Смотреть все фотографии</a></div>
</div>