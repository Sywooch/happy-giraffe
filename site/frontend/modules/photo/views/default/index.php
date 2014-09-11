<?php
/**
 * @var PhotoController $this
 * @var $json
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('myPhotos', array('ko' => 'knockout', 'MyPhotos' => 'photo/myPhotos'), "vvm = new MyPhotos($json); ko.applyBindings(vvm, document.getElementById('myPhotos'))");
?>

<div class="page-col page-col__user" id="myPhotos">
    <div class="page-col_cont page-col_cont__in">
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
        <!-- ko module: { name : 'myPhotosAlbum', data : albums, template : 'photo/album' } -->
        <!-- /ko -->
        <div class="heading-small margin-t40">Альбомы без фотографий</div>
        <!-- album-empty-->
        <div class="album-empty">
            <div class="album-empty_hold"><a href="" class="album-empty_t">Харьковский уикенд </a><a href="" class="album-empty_desc">В половине чашке горячей воды разведем желатин. Дадим ему остыть. Для торта разводим согласно инструкции. Поломаем не небольшие кусочки ... </a></div><a href="" class="album-photo-add"></a><a href="" class="album-empty_del"></a>
            <div class="album-empty_count">0</div>
        </div>
        <!-- /album-empty-->
        <!-- album-empty-->
        <div class="album-empty">
            <div class="album-empty_hold"><a href="" class="album-empty_t">Харьковский уикенд</a></div><a href="" class="album-photo-add"></a><a href="" class="album-empty_del"></a>
            <div class="album-empty_count">0</div>
        </div>
        <!-- /album-empty-->
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
</div>