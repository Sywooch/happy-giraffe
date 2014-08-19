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
            <?php $this->renderPartial('//banners/_route'); ?>
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
