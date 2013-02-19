<?php
/**
 * Author: alexk984
 * Date: 01.02.13
 *
 * @var $route Route
 * @var $texts array
 * @var $points array
 */

$distance = $route->distance;

$fuels = FuelCost::model()->findAll();
$result = array();
foreach ($fuels as $fuel) {
    $result[] = array(
        'id' => $fuel->currency_id,
        'name' => $fuel->currency_name,
        'value' => $fuel->cost,
    );
}

$js = 'Routes.init("' . $route->cityFrom->getFullName() . '", "' . $route->cityTo->getFullName() . '");
ko.applyBindings(new RoutesModel("' . $distance . '", ' . CJavaScript::encode($result) . '));';

$middle_points = array_slice($points, 1, count($points) - 2);
$index = 1;
foreach ($middle_points as $point) {
    $c = $point['city']->coordinates;

    if ($c !== null && !empty($c->location_lat) && !empty($c->location_lng))
        $js .= "
new google.maps.Marker({
    position: new google.maps.LatLng(" . $c->location_lat . ", " . $c->location_lng . "),
    map: Routes.map,
    icon: '/images/map_marker-2.png',
    title:'" . $point['city']->name . "'
});";
    $index++;
}

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

Yii::app()->clientScript
    ->registerScriptFile('http://maps.googleapis.com/maps/api/js?libraries=places&key=' . Yii::app()->params['google_map_key'] . '&sensor=true')
    ->registerCoreScript('jquery.ui')
    ->registerScriptFile('/javascripts/knockout-2.2.1.js')
    ->registerScript('routes_module', $js)
    ->registerScriptFile($baseUrl . '/routes.js');

?>
<style type="text/css">
    .pac-container:after {
        content: none !important;
    }
</style>
<div class="map-route-search">
    <a href="#" class="map-route-search_new a-pseudo" onclick="$('form.map-route-search_form').toggle();">Новый
        маршрут</a>

    <h1 class="map-route-search_h1"><?=$texts[0] ?></h1>

    <form action="" class="map-route-search_form clearfix" style="display: none;">
        <input id="city_from" type="text" class="map-route-search_itx itx-bluelight" placeholder="Откуда">
        <a href="javascript:;" class="map-route-search_reverse" onclick="Routes.reversePlaces()"></a>
        <input id="city_to" type="text" class="map-route-search_itx itx-bluelight" placeholder="Куда">
        <button class="btn-green map-route-search_btn" onclick="Routes.go()">Проложить <br> маршрут</button>
    </form>
    <p><?=$texts[1] ?></p>

</div>
<div class="margin-b30">
    <div id="map_canvas" style="width:960px; height:389px;"></div>
</div>
<div class="content-cols clearfix">
    <div class="col-1">
        <div class="map-route-calc">
            <div class="map-route-calc_item">
                <div class="clearfix">
                    <div class="map-route-calc_img">
                        <img src="/images/services/map-route/map-route-car.png" alt="">
                    </div>
                    <div class="map-route-calc_t clearfix"><?=$texts[3] ?></div>
                </div>
                <div class="map-route-calc_value"><span data-bind="text: distance"></span> <span
                        class="map-route-calc_units">км</span></div>
                <div class="map-route-calc_desc"><?=$texts[4] ?></div>
            </div>

            <div class="map-route-calc_item">
                <div class="clearfix">
                    <div class="map-route-calc_img">
                        <img src="/images/services/map-route/map-route-time.png" alt="">
                    </div>
                    <div class="map-route-calc_t clearfix"><?=$texts[5] ?></div>
                </div>
                <div class="map-route-calc_row clearfix">
                    <input type="text" class="map-route-calc_itx map-route-calc_itx__speed itx-bluelight"
                           data-bind="value: speed, valueUpdate: 'afterkeydown'">
                    <label class="map-route-calc_label">Ср. скорость <br> км / ч</label>
                </div>
                <div class="map-route-calc_value">
                    <span data-bind="text: DurationHours"></span> <span class="map-route-calc_units">ч</span>
                    <span data-bind="text: DurationMinutes"></span> <span class="map-route-calc_units">м</span>
                </div>
                <div class="map-route-calc_desc"><?=$texts[6] ?></div>
            </div>

            <div class="map-route-calc_item">
                <div class="clearfix">
                    <div class="map-route-calc_img">
                        <img src="/images/services/map-route/map-route-fuel-cost.png" alt="">
                    </div>
                    <div class="map-route-calc_t clearfix">Расход и стоимость топлива</div>
                </div>
                <div class="map-route-calc_row clearfix">
                    <input type="text" name="" class="map-route-calc_itx map-route-calc_itx__fuel itx-bluelight"
                           data-bind="value: fuelConsumption, valueUpdate: 'afterkeydown'">
                    <label class="map-route-calc_label">л. / 100 км</label>
                </div>
                <div class="map-route-calc_row clearfix">
                    <input type="text" name="" class="map-route-calc_itx map-route-calc_itx__cost itx-bluelight"
                           data-bind="value: fuelCost, valueUpdate: 'afterkeydown'">
                    <label class="map-route-calc_label">
                        <div class="chzn-v2">
                            <?= CHtml::dropDownList('currency', 1, CHtml::listData(FuelCost::model()->findAll(), 'currency_id', 'title'),
                            array('class' => 'chzn w-85', 'data-bind' => 'value: currentCurrency')); ?>
                        </div>
                    </label>
                </div>
                <div class="map-route-calc_value">
                    <span data-bind="text: fuelNeeds"></span> <span class="map-route-calc_units">л</span>
                </div>
                <div class="map-route-calc_value">
                    <span data-bind="text: summaryCost"></span> <span class="map-route-calc_units"
                                                                      data-bind="text: currencySign">руб.</span>
                </div>
            </div>
        </div>

        <div class="map-route-share">
            <div class="map-route-share_tx"><?=$texts[7] ?></div>
            <div class="custom-likes-small">
                <a href="" class="custom-like-small">
                    <span class="custom-like-small_icon odkl"></span>
                </a>
                <a href="" class="custom-like-small">
                    <span class="custom-like-small_icon mailru"></span>
                </a>

                <a href="" class="custom-like-small">
                    <span class="custom-like-small_icon vk"></span>
                </a>

                <a href="" class="custom-like-small">
                    <span class="custom-like-small_icon fb"></span>
                </a>
                <a href="javascript:;" class="custom-like-small" onclick="$('#email-popup').toggle();">
                    <span class="custom-like-small_icon mail"></span>
                </a>

                <div id="email-popup" class="custom-like-small-popup">
                    <div class="custom-like-small-popup_t">Отправить маршрут другу</div>
                    <input type="text" name="" class="custom-like-small-popup_it itx-bluelight"
                           placeholder="Свой email">
                    <input type="text" name="" class="custom-like-small-popup_it itx-bluelight"
                           placeholder="Email друга">

                    <div class="clearfix"><img src="/images/captcha.png"></div>
                    <input type="text" name="" class="custom-like-small-popup_it itx-bluelight"
                           placeholder="Введите знаки с картинки">
                    <button class="custom-like-small-popup_btn btn-green btn-medium">Отправить</button>
                </div>
            </div>
            <div class="map-route-share_tx">Ссылка на этот маршрут:</div>
            <div class="link-box">
                <a href="<?=$route->url ?>"
                   class="link-box_a"><?=$route->getUrl(true) ?></a>
            </div>
        </div>

        <div class="watchers">
            <div class="watchers_t">Маршрут <br>просмотрели</div>
            <div class="watchers_eye"></div>
            <div class="watchers_count"><?=PageView::model()->viewsByPath($route->url)?></div>
        </div>
    </div>


    <div class="col-23">
        <?php $this->renderPartial('_transit_points', array('route' => $route, 'texts' => $texts, 'points' => $points)); ?>

        <div class="map-route-other">

            <?php $this->renderPartial('links', array('route' => $route)); ?>

        </div>

        <?php $this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $route, 'notice' => $texts[8])); ?>

        <?php
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
        ?>
    </div>
</div>