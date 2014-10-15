<?php
/**
 * @var Route $route
 */
$js = 'Routes.init("' . $route->cityFrom->getFullName() . '", "' . $route->cityTo->getFullName() . '", function() {';
$middle_points = array_slice($route->intermediatePoints, 1, count($route->intermediatePoints) - 2);
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
$js .= '});';

$way_points = Route::get8Points($middle_points);
$waypoints_js = 'var way_points = [';
foreach ($way_points as $point) {
    $c = $point['city']->coordinates;

    if ($c !== null && !empty($c->location_lat) && !empty($c->location_lng)){
        $waypoints_js .= '{location:new google.maps.LatLng(' . $c->location_lat . ', ' . $c->location_lng . '),stopover:false},';
    }
}
$waypoints_js .= '];';

$cs = Yii::app()->clientScript;
$cs->registerAMD('routes_module', array('Routes' => 'routes'), $js);
$cs->registerAMD('routes_waypoints', array('Routes' => 'routes'), $waypoints_js);
?>

<div class="map-route">
    <!-- Заголовок-->
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <div class="heading-h1-hold">
                <h1 class="heading-link-xxl"><?=$route->texts[0]?></h1>
            </div>
        </div>
    </div>
    <!-- Форма поиска маршрута-->
    <div class="map-route-f map-route-f__row">
        <div class="map-route-f_open-hold">
            <!-- Клик отвечает за  показ формы поиска--><span class="map-route-f_open" onclick="$(this).parent().next().toggle();">Составить другой маршрут</span>
        </div>
        <!-- По умолчанию форма должна быть скрыта, с помощью стля или класса displa-n-->
        <div style="display: none"><?php $this->widget('RoutesFormWidget'); ?></div>
        <div class="map-route-f_tx"><?=$route->texts[1]?></div>
    </div>
    <!-- /Форма поиска маршрута-->
    <!-- Карта-->
    <div class="route-canvas">
        <div id="map_canvas" style="height:389px;"></div>

        <div class="route-canvas_ovr" id="waitLoader" style="display: none;">
            <div class="route-canvas_ovr-hold">
                <div class="route-canvas_ovr-tx">Подождите. Мы формируем для вас маршрут.</div>
                <div class="loader"><img src="/lite/images/ico/ajax-loader.gif" alt="Загружается" class="loader_img">
                    <div class="loader_tx">Загрузка</div>
                </div>
            </div>
        </div>

        <div class="route-canvas_ovr errorMessage" id="badRoute" style="display: none;">
            <div class="route-canvas_ovr-hold">
                <div class="route-canvas_ovr-tx"> Извините. Этот маршрут проложить невозможно.</div>
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
            <div class="map-route_view">
                Маршрут <?=Str::GenerateNoun(array('посмотрел', 'посмотрели', 'посмотрели'), PageView::model()->viewsByPath($route->url))?> <span class="display-ib"><?=PageView::model()->viewsByPath($route->url)?></span> <?=Str::GenerateNoun(array('водитель', 'водителя', 'водителей'), PageView::model()->viewsByPath($route->url))?>
            </div>
        </div>
        <div class="map-route_cont">
            <?php if (Yii::app()->vm->getVersion() == VersionManager::VERSION_DESKTOP) $this->widget('WaypointsTableWidget', compact('route')); ?>
            <!-- Реклама яндекса-->
            <?php $this->renderPartial('//banners/_direct_others'); ?>

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
        </div>
    </div>
</div>
