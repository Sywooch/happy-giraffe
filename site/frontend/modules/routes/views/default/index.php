<?php
/**
 * @var LiteController $this
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('routes', array('Routes' => 'routes'), 'Routes.initAutoComplete();')
?>

<div class="map-route">
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="heading-h1-hold">
                <h1 class="heading-link-xxl">Составь маршрут для автомобиля</h1>
            </div>
        </div>
    </div>
    <div class="map-route-f map-route-f__main">
        <div class="map-route-f_desc">Собираясь в поездку на автомобиле очень важно грамотно проложить маршрут следования и просчитать его мельчайшие нюансы. Прежде чем отправляться в путь узнайте, как доехать до намеченного пункта, сколько километров вам предстоит преодолеть и какое количество времени это займет. С полной информацией о дорогах, картах и пробках на пути следования ваша поездка будет безопасной и интересной. Пользуйтесь нашим сервисом “Маршруты” и путешествуйте на автомобиле с удовольствием!</div>
        <div class="map-route-f_hold">
            <div class="map-route-f_i">
                <input type="text" placeholder="Откуда" class="itx-simple map-route-f_inp map-route-f_inp__a" id="city_from">
            </div>
            <div class="map-route-f_revers" onclick="require(['routes'], function(Routes) {Routes.reversePlaces();});"></div>
            <div class="map-route-f_i">
                <input type="text" placeholder="Куда" class="itx-simple map-route-f_inp map-route-f_inp__b" id="city_to">
            </div>
            <div class="map-route-f_btn-hold"><a href="javascript:void(0)" class="btn btn-success btn-xm" onclick="require(['routes'], function(Routes) {Routes.go();});">Проложить маршрут</a></div>
        </div>
    </div>
    <div class="map-route-desc">
        <ul class="map-route-desc_ul clearfix">
            <li class="map-route-desc_li clearfix">
                <div class="map-route-desc_img"><img src="/lite/images/services/map-route/map-route-desc-1.jpg" alt=""></div><strong class="map-route-desc_t">Расчет<br>расстояния</strong>
                <div class="map-route-desc_tx">Узнавайте, сколько километров вам предстоит преодолеть</div>
            </li>
            <li class="map-route-desc_li clearfix">
                <div class="map-route-desc_img"><img src="/lite/images/services/map-route/map-route-desc-2.jpg" alt=""></div><strong class="map-route-desc_t">Время<br>в пути</strong>
                <div class="map-route-desc_tx">Уточняйте время,<br>проведенное в пути</div>
            </li>
            <li class="map-route-desc_li clearfix">
                <div class="map-route-desc_img"><img src="/lite/images/services/map-route/map-route-desc-3.jpg" alt=""></div><strong class="map-route-desc_t">Промежуточные<br>пункты маршрута</strong>
                <div class="map-route-desc_tx">Смотрите населенные пункты<br>на пути следования маршрута</div>
            </li>
            <li class="map-route-desc_li clearfix">
                <div class="map-route-desc_img"><img src="/lite/images/services/map-route/map-route-desc-4.jpg" alt=""></div><strong class="map-route-desc_t">Расход<br>бензина</strong>
                <div class="map-route-desc_tx">Считайте, сколько бензина<br>вам понадобится для поездки</div>
            </li>
        </ul>
    </div>
    <div class="b-main_cont">
        <div class="map-route-abc">
            <h3 class="map-route-abc_t">Поиск маршрутов по городу</h3>
            <?php $this->widget('AlphabetWidget'); ?>
        </div>
    </div>
</div>

<div style="display:none;" id="map_canvas"></div>
