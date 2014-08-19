<?php
/**
 * @var RoutesFormWidget $this
 */
?>

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
