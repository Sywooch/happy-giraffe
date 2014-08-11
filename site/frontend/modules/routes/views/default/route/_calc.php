<?php
$cs = Yii::app()->clientScript;
?>

<div class="map-route-calc">
    <div class="map-route-calc_hold">
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-car.png" alt=""></div>
                <div class="map-route-calc_t">Расстояние <span class="hidden-xs">между Киевом и Донецком</span></div>
            </div>
            <div class="map-route-calc_value">1 388<span class="map-route-calc_units">км. </span></div>
            <div class="map-route-calc_desc">Столько километров от Киева до Донецка на автомобиле</div>
        </div>
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-time.png" alt=""></div>
                <div class="map-route-calc_t">Время в пути <span class="hidden-xs"> от Киева до Донецка</span></div>
            </div>
            <label for="route-time" class="map-route-calc_label">Ср. скорость км / ч </label>
            <div class="map-route-calc_row clearfix">
                <input type="text" name="" value="80" id="route-time" class="itx-simple map-route-calc_itx">
                <div class="map-route-calc_value">14<span class="map-route-calc_units">ч. </span> 8<span class="map-route-calc_units">мин.</span></div>
            </div>
            <div class="map-route-calc_desc">Столько времени ехать от Киева до Донецка</div>
        </div>
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-fuel.png" alt=""></div>
                <div class="map-route-calc_t">Расход  топлива</div>
            </div>
            <label for="route-fuel" class="map-route-calc_label">Ср. расход (л. / 100 км)</label>
            <div class="map-route-calc_row clearfix">
                <input type="text" name="" value="80" id="route-fuel" class="itx-simple map-route-calc_itx">
                <div class="map-route-calc_value">140<span class="map-route-calc_units">л</span></div>
            </div>
        </div>
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-cost.png" alt=""></div>
                <div class="map-route-calc_t">Стоимость топлива</div>
            </div>
            <label for="route-cost" class="map-route-calc_label">Ср. расход (л. / 100 км)</label>
            <div class="map-route-calc_row clearfix">
                <input type="text" name="" value="80" id="route-cost" class="itx-simple map-route-calc_itx">
                <script src="/lite/javascript/select2.js"></script>
                <script src="/lite/javascript/select2_locale_ru.js"></script>
                <script>
                    $(document).ready(function () {

                        // Измененный tag select
                        $(".select-cus__search-off").select2({
                            minimumResultsForSearch: -1,
                            dropdownCssClass: 'select2-drop__search-off',
                            escapeMarkup: function(m) { return m; }
                        });
                        $(".select-cus__search-off .select2-search, .select-cus__search-off .select2-focusser").remove();

                    });
                </script>
                <select name="" class="select-cus select-cus__search-off select-cus__gray">
                    <option value="1">руб / л.</option>
                    <option value="2">руб / гал.</option>
                    <option value="3">руб / бар.</option>
                </select>
                <div class="map-route-calc_value">3 898  <span class="map-route-calc_units">руб.</span></div>
            </div>
        </div>
    </div>
</div>