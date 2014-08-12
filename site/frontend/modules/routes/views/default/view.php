<?php
/**
 * @var Route $route
 */
$texts = $route->getTexts();
?>

<div class="map-route">
    <!-- Заголовок-->
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="heading-h1-hold">
                <h1 class="heading-link-xxl"><?=$texts[0]?></h1>
            </div>
        </div>
    </div>
    <!-- Форма поиска маршрута-->
    <div class="map-route-f map-route-f__row">
        <div class="map-route-f_open-hold">
            <!-- Клик отвечает за  показ формы поиска--><span class="map-route-f_open">Составить другой маршрут</span>
        </div>
        <!-- По умолчанию форма должна быть скрыта, с помощью стля или класса displa-n-->
        <div class="map-route-f_hold">
            <div class="map-route-f_i">
                <input type="text" name="" placeholder="Откуда" class="itx-simple map-route-f_inp map-route-f_inp__a">
            </div>
            <div class="map-route-f_revers"></div>
            <div class="map-route-f_i">
                <input type="text" name="" placeholder="Куда" class="itx-simple map-route-f_inp map-route-f_inp__b">
            </div>
            <div class="map-route-f_btn-hold"><a href="#" class="btn btn-success btn-xm">Проложить маршрут</a></div>
        </div>
        <div class="map-route-f_tx">Узнайте, как доехать на авто от Киева до Донецка. Схема трассы Киев-Донецк на карте. Выбирайте нужные вам дороги, трассы, шоссе и магистрали на пути от Киева до Донецка</div>
    </div>
    <!-- /Форма поиска маршрута-->
    <!-- Карта-->
    <div class="route-canvas"><img src="/lite/images/services/map-route/map.jpg" alt="">
        <!-- Если оишбка добавить класс errorMessage и непоказывать блок loader -->
        <div class="route-canvas_ovr">
            <div class="route-canvas_ovr-hold">
                <div class="route-canvas_ovr-tx">Подождите. Мы формируем для вас маршрут.</div>
                <div class="loader"><img src="/lite/images/ico/ajax-loader.gif" alt="Загружается" class="loader_img">
                    <div class="loader_tx">Загрузка</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Карта-->
    <div class="b-main_col-hold clearfix">
        <div class="map-route_aside">
            <?php $this->renderPartial('route/_calc', compact('route')); ?>
            <div class="map-route_view"></div>
        </div>
        <div class="map-route_cont">
            <div class="heading-xl visible-md-block">Пункты следования на пути Киев - Донецк</div>
            <table class="map-route-table visible-md-table">
                <colgroup>
                    <col class="map-route-table_col1">
                    <col class="map-route-table_col2">
                    <col class="map-route-table_col3">
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead class="map-route-table_thead">
                <tr>
                    <td class="map-route-table_thead-td"></td>
                    <td class="map-route-table_thead-td textalign-l">Пункт / регион</td>
                    <td class="map-route-table_thead-td">Трасса</td>
                    <td class="map-route-table_thead-td">Время участка </td>
                    <td class="map-route-table_thead-td">Время в пути</td>
                    <td class="map-route-table_thead-td">Участок, км     </td>
                    <td class="map-route-table_thead-td">Всего, км</td>
                </tr>
                </thead>
                <tbody>
                <tr class="map-route-table_tr">
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">
                            <div class="map-route-start"></div>
                        </div>
                    </td>
                    <td class="map-route-table_td textalign-l">
                        <div class="map-route-table_hold"><strong>Киев</strong><br>Вологодская обл. Волог</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold"><strong>M8</strong></div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                </tr>
                <tr class="map-route-table_tr">
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">
                            <div class="map-route-point">1</div>
                        </div>
                    </td>
                    <td class="map-route-table_td textalign-l">
                        <div class="map-route-table_hold"><strong>Киев</strong><br>Вологодская обл.</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold"><strong>M8</strong></div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                </tr>
                <tr class="map-route-table_tr">
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">
                            <div class="map-route-point">99</div>
                        </div>
                    </td>
                    <td class="map-route-table_td textalign-l">
                        <div class="map-route-table_hold"><strong>Киев</strong><br>Вологодская обл.</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold"><strong>M8</strong></div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                </tr>
                <tr class="map-route-table_tr">
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">
                            <div class="map-route-finish"></div>
                        </div>
                    </td>
                    <td class="map-route-table_td textalign-l">
                        <div class="map-route-table_hold"><strong>Киев</strong><br>Вологодская обл.</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold"><strong>M8</strong></div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">0:00</div>
                    </td>
                    <td class="map-route-table_td">
                        <div class="map-route-table_hold">1:00</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- Реклама яндекса-->
            <div class="adv-yandex"><a href="#" target="_blank"><img src="/lite/images/example/yandex-w600.jpg" alt=""></a></div>
            <!-- баннер на всю ширину-->
            <!-- Изабражение вставляется через background для поизиционирования через css-->
            <style type="text/css">
                /* Ширина изображения 600px */
                .ban-read-more {
                    background-image: url('/lite/images/example/w600-h355-1.jpg');
                }
                /* Ширина изображения до 1000px*/
                @media (min-width: 640px) {
                    .ban-read-more {
                        background-image: url('/lite/images/example/w1000-h510-2.jpg');
                    }
                }
            </style>
            <div class="ban-read-more">
                <div class="ban-read-more_hold">
                    <div class="ban-read-more_cont">
                        <div class="ban-read-more_t-sub">Рекомендуем для чтения</div>
                        <div class="ban-read-more_author clearfix">
                            <!-- Аватарки размером 40*40-->
                            <!-- ava--><a href="" class="ava ava__middle ava__small-xs"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a href="" class="a-light">Ангелина Богоявленская</a>
                        </div><a href="" class="ban-read-more_t">20 самых опасных маршрутов в мире</a>
                        <div class="ban-read-more_desc">Вот, девочки, напала на вот такую красоту в интернете. И вдруг вспомнила, что муж у меня уже много много лет мечтает ...</div><a href="" class="ban-read-more_arrow"></a>
                    </div>
                </div>
            </div>
            <!-- /баннер-->
        </div>
    </div>
</div>