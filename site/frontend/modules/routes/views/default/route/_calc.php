<?php
/**
 * @var Route $route
 */
$fuels = FuelCost::model()->findAll();
$result = array();
foreach ($fuels as $fuel) {
    $result[] = array(
        'id' => $fuel->currency_id,
        'name' => $fuel->currency_name,
        'value' => $fuel->cost,
    );
}

$cs = Yii::app()->clientScript;
$cs->registerAMD('routes-calc', array('RoutesModel' => 'routesCalc', 'ko' => 'knockout', 'ko_library' => 'ko_library'), 'ko.applyBindings(new RoutesModel("' . $route->distance . '", ' . CJavaScript::encode($result) . '));');
?>

<div class="map-route-calc">
    <div class="map-route-calc_hold">
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-car.png" alt=""></div>
                <div class="map-route-calc_t">Расстояние <span class="hidden-xs"><?=$route->texts[3]?></span></div>
            </div>
            <div class="map-route-calc_value"><span data-bind="text: distance"></span><span class="map-route-calc_units">км. </span></div>
            <div class="map-route-calc_desc"><?=$route->texts[4]?></div>
        </div>
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-time.png" alt=""></div>
                <div class="map-route-calc_t">Время в пути <span class="hidden-xs"> <?=$route->texts[5]?></span></div>
            </div>
            <label for="route-time" class="map-route-calc_label">Ср. скорость км / ч </label>
            <div class="map-route-calc_row clearfix">
                <input type="text" name="" value="80" id="route-time" class="itx-simple map-route-calc_itx" data-bind="value: speed, valueUpdate: 'afterkeydown'">
                <div class="map-route-calc_value"><span data-bind="text: DurationHours"></span><span class="map-route-calc_units">ч. </span> <span data-bind="text: DurationMinutes"></span><span class="map-route-calc_units">мин.</span></div>
            </div>
            <div class="map-route-calc_desc"><?=$route->texts[6]?></div>
        </div>
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-fuel.png" alt=""></div>
                <div class="map-route-calc_t">Расход  топлива</div>
            </div>
            <label for="route-fuel" class="map-route-calc_label">Ср. расход (л. / 100 км)</label>
            <div class="map-route-calc_row clearfix">
                <input type="text" name="" value="80" id="route-fuel" class="itx-simple map-route-calc_itx" data-bind="value: fuelConsumption, valueUpdate: 'afterkeydown'">
                <div class="map-route-calc_value"><span data-bind="text: fuelNeeds"></span><span class="map-route-calc_units">л</span></div>
            </div>
        </div>
        <div class="map-route-calc_item">
            <div class="clearfix">
                <div class="map-route-calc_img"><img src="/lite/images/services/map-route/map-route-cost.png" alt=""></div>
                <div class="map-route-calc_t">Стоимость топлива</div>
            </div>
            <label for="route-cost" class="map-route-calc_label">Ср. расход (л. / 100 км)</label>
            <div class="map-route-calc_row clearfix">
                <input type="text" name="" value="80" id="route-cost" class="itx-simple map-route-calc_itx" data-bind="value: fuelCost, valueUpdate: 'afterkeydown'">
                <?=CHtml::dropDownList('currency', 1, CHtml::listData(FuelCost::model()->findAll(), 'currency_id', 'title'),
                    array('class' => 'select-cus select-cus__gray', 'data-bind' => 'value: currentCurrency, select2: {
                            minimumResultsForSearch: -1,
                            dropdownCssClass: "select2-drop__search-off",
                            escapeMarkup: function(m) { return m; }
                        }')); ?>
                <div class="map-route-calc_value"><span data-bind="text: summaryCost"></span>  <span class="map-route-calc_units" data-bind="text: currencySign"></span></div>
            </div>
        </div>
    </div>
</div>