<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
if ($this->visible){
$js = 'var geocoder;
    var map;
    var placemark;
    var s;

    $(function () {
        BalloonStyle();

        map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
        map.enableScrollZoom();

        // Создание объекта геокодера
        var user_loc = "'. $this->user->getLocationString() .'";
        geocoder = new YMaps.Geocoder(user_loc);
        ShowNewLoc();

        YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
            console.log("Произошла ошибка: " + errorMessage)
        });
     });

    function ShowNewLoc() {
        YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
            if (geocoder.length()) {
                map.setBounds(geocoder.get(0).getBounds());
                map.removeOverlay(placemark);
                placemark = new YMaps.Placemark(map.getCenter(), {style: s});
                placemark.name = "'.$this->user->getPublicLocation() .'";
                map.addOverlay(placemark);
            }
        });
    }

    function BalloonStyle(){
        // Создает стиль
        s = new YMaps.Style();
        // Создает стиль значка метки
        s.iconStyle = new YMaps.IconStyle();

        //стиль метки
        s.iconStyle.href = "/images/map_marker2.png";
        s.iconStyle.size = new YMaps.Point(34, 46);
        s.iconStyle.offset = new YMaps.Point(-17, -46);
    }';

Yii::app()->clientScript
    ->registerScript('LocaionWidget', $js)
    ->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=' . Yii::app()->params['yandex_map_key']);
?>
<div class="user-map">

    <div class="box-title">Я живу здесь</div>

    <div id="YMapsID" style="width:322px;height:199px;"></div>

</div><?php }