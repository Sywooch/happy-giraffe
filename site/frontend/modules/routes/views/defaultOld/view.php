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
ko.applyBindings(new RoutesModel("' . $distance . '", ' . CJavaScript::encode($result) . '));
';



$middle_points = array_slice($points, 1, count($points) - 2);
$index = 1;
foreach ($middle_points as $point) {
    $c = $point['city']->coordinates;
    if ($c === null){
        $p = new GoogleCoordinatesParser;
        $p->city = $point['city'];
        $p->parseCity();
        $c = $p->coordinates;
    }

    if ($c !== null && !empty($c->location_lat) && !empty($c->location_lng))
        $js .= "
new google.maps.Marker({
    position: new google.maps.LatLng(" . $c->location_lat . ", " . $c->location_lng . "),
    map: Routes.map,
    icon: '/images/services/map-route/point/point-".$index.".png',
    title:'" . $point['city']->name . "',
});";
    $index++;
}

$way_points = Route::get8Points($middle_points);
$waypoints_js = 'var way_points = [';
foreach ($way_points as $point) {
    $c = $point['city']->coordinates;

    if ($c !== null && !empty($c->location_lat) && !empty($c->location_lng)){
        $waypoints_js .= '{location:new google.maps.LatLng(' . $c->location_lat . ', ' . $c->location_lng . '),stopover:false},';
    }
}
$waypoints_js .= '];';

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

Yii::app()->clientScript
    ->registerScriptFile('http://maps.googleapis.com/maps/api/js?v=3&libraries=places&sensor=false')
    ->registerCoreScript('jquery.ui')
    ->registerScript('routes_module', $js)
    ->registerScript('routes_waypoints', $waypoints_js, CClientScript::POS_BEGIN)
    ->registerScriptFile($baseUrl . '/routes.js');

$this->breadcrumbs = array(
    'Интересы и увлечения' => array('/interests-and-hobby'),
    'Наш автомобиль' => array('/auto'),
    'Маршруты'
);
?>
<div class="margin-l-20">
    <div class="col-white padding-20 clearfix">

        <!-- <div id="crumbs"><a href="/">Главная</a> &gt; <a href="/auto/">Авто</a> &gt; <span>Маршруты</span></div> -->

        <div class="map-route-search">
            <a href="javascript:;" class="map-route-search_new a-pseudo" onclick="$('form.map-route-search_form').toggle();">Новый маршрут</a>

            <h1 class="map-route-search_h1"><?=$texts[0] ?></h1>

            <form action="" class="map-route-search_form clearfix" style="display: none;">
                <input id="city_from" type="text" class="map-route-search_itx itx-bluelight" placeholder="Откуда">
                <a href="javascript:;" class="map-route-search_reverse" onclick="Routes.reversePlaces()"></a>
                <input id="city_to" type="text" class="map-route-search_itx itx-bluelight" placeholder="Куда">
                <button class="btn-green map-route-search_btn" onclick="Routes.go();return false;">Проложить <br> маршрут</button>
            </form>
            <p><?=$texts[1] ?></p>

        </div>
        <div class="margin-b30 map-canvas">
            <div id="map_canvas" style="width:960px; height:389px;"></div>
            <div id="waitLoader" class="map-canvas_overlay" style="display:none;">
                Подождите. Мы формируем для вас маршрут.
                <div id="infscr-loading"><img src="/images/ico/ajax-loader.gif" alt="Loading..."><div>Загрузка</div></div>
            </div>
            <div id="badRoute" class="map-canvas_overlay map-canvas_overlay__error" style="display:none;">
                Извините. Этот маршрут проложить невозможно.
            </div>
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
                            <span data-bind="text: summaryCost"></span> <span class="map-route-calc_units" data-bind="text: currencySign">руб.</span>
                        </div>
                    </div>
                </div>

                <div class="watchers">
                    <div class="watchers_t">Маршрут <br>просмотрели</div>
                    <div class="watchers_eye"></div>
                    <div class="watchers_count"><?=PageView::model()->viewsByPath($route->url)?></div>
                </div>

                <?php $this->renderPartial('send',array('route'=>$route, 'texts' => $texts)); ?>

            </div>


            <div class="col-23">
                <?php $this->renderPartial('//banners/_route'); ?>
                <?php $this->renderPartial('_transit_points', array('route' => $route, 'texts' => $texts, 'points' => $points)); ?>

                <!--AdFox START-->
                <!--giraffe-->
                <!--Площадка: Весёлый Жираф / * / *-->
                <!--Тип баннера: Безразмерный 680х470-->
                <!--Расположение: <низ страницы>-->
                <script type="text/javascript">
                    <!--
                    if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
                    if (typeof(document.referrer) != 'undefined') {
                        if (typeof(afReferrer) == 'undefined') {
                            afReferrer = escape(document.referrer);
                        }
                    } else {
                        afReferrer = '';
                    }
                    var addate = new Date();
                    var scrheight = '', scrwidth = '';
                    if (self.screen) {
                        scrwidth = screen.width;
                        scrheight = screen.height;
                    } else if (self.java) {
                        var jkit = java.awt.Toolkit.getDefaultToolkit();
                        var scrsize = jkit.getScreenSize();
                        scrwidth = scrsize.width;
                        scrheight = scrsize.height;
                    }
                    document.write('<scr' + 'ipt type="text/javascript" src="//ads.adfox.ru/211012/prepareCode?pp=i&amp;ps=bkqy&amp;p2=evor&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                    // -->
                </script>
                <!--AdFox END-->


                <div class="map-route-other" style="display: none;">

                    <?php //$this->renderPartial('links', array('route' => $route)); ?>

                </div>

                <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $route, 'full' => true, 'notice' => $texts[8])); ?>

            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .pac-container:after {content: none !important;}
    #map_canvas img{max-width:none;}
</style>