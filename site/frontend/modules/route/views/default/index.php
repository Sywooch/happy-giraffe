<?php
/**
 * Author: alexk984
 * Date: 01.02.13
 *
 * @var $route Route
 * @var $texts array
 */

$js = 'Routes.initAutoComplete();';

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

Yii::app()->clientScript
    ->registerScriptFile('http://maps.googleapis.com/maps/api/js?libraries=places&key=' . Yii::app()->params['google_map_key'] . '&sensor=true')
    ->registerCoreScript('jquery.ui')
    ->registerScript('routes_module', $js)
    ->registerScriptFile($baseUrl . '/routes.js');

?>
<style type="text/css">
    .pac-container:after {content: none !important;}
</style>
<div class="map-route-h">
    <h1 class="map-route-h_t">Составь маршрут для автомобиля</h1>
    <div class="map-route-h_form clearfix">
        <form action="" class="">
            <div class="map-route-h_start">A</div>
            <input id="city_from" type="text" class="map-route-h_itx itx-bluelight" placeholder="Откуда едем?">
            <a href="javascript:;" class="map-route-h_reverse" onclick="Routes.reversePlaces()"></a>
            <div class="map-route-h_start map-route-h_start__b">B</div>
            <input id="city_to" type="text" class="map-route-h_itx itx-bluelight" placeholder="Куда едем?">
            <button class="btn-green map-route-h_btn" onclick="Routes.go();return false;">Проложить <br> маршрут</button>
        </form>
    </div>
</div>

<div class="map-route-desc">
    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются   молочные железы, объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности</p>
    <ul class="map-route-desc_ul clearfix">
        <li class="map-route-desc_li">
            <div class="map-route-desc_img">
                <img src="/images/services/map-route/map-route-desc-1.jpg" alt="">
            </div>
            <strong class="map-route-desc_t">Расчет <br>расстояния</strong>
            <div class="map-route-desc_tx">Узнавайте, сколько километров вам предстоит преодолеть</div>
        </li>
        <li class="map-route-desc_li">
            <div class="map-route-desc_img">
                <img src="/images/services/map-route/map-route-desc-2.jpg" alt="">
            </div>
            <strong class="map-route-desc_t">Время <br>в пути</strong>
            <div class="map-route-desc_tx">Уточняйте время, <br>проведенное в пути	</div>
        </li>
        <li class="map-route-desc_li">
            <div class="map-route-desc_img">
                <img src="/images/services/map-route/map-route-desc-3.jpg" alt="">
            </div>
            <strong class="map-route-desc_t">Промежуточные <br>пункты маршрута</strong>
            <div class="map-route-desc_tx">Смотрите населенные пункты <br>  на пути следования маршрута</div>
        </li>
        <li class="map-route-desc_li">
            <div class="map-route-desc_img">
                <img src="/images/services/map-route/map-route-desc-4.jpg" alt="">
            </div>
            <strong class="map-route-desc_t">Расход <br>бензина</strong>
            <div class="map-route-desc_tx">Считайте, сколько бензина <br>вам понадобится для поездки</div>
        </li>
    </ul>
</div>

<div style="display:none;" id="map_canvas"></div>

