<?php
/**
 * @var $route Route
 */
$links = $route->getOrderedLinks();
?><h3 class="map-route-other_title">С этим маршрутом искали</h3>
<div class="clearfix">
    <ul class="map-route-other_ul clearfix">
        <?php foreach ($links[0] as $link): ?>
        <li class="map-route-other_li">
            <a href="<?=$link->routeTo->getUrl() ?>"><?=$link->text ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
    <ul class="map-route-other_ul clearfix">
        <?php foreach ($links[1] as $link): ?>
        <li class="map-route-other_li">
            <a href="<?=$link->routeTo->getUrl() ?>"><?=$link->text ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>