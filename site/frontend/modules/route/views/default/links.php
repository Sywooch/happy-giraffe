<?php
/**
 * @var $route Route
 */
?><h3 class="map-route-other_title">С этим маршрутом искали</h3>
<ul class="map-route-other_ul clearfix">
    <?php foreach ($route->outLinks as $link): ?>
        <li class="map-route-other_li">
            <a href="<?=$link->routeTo->getUrl() ?>"><?=$link->text ?></a>
        </li>
    <?php endforeach; ?>
</ul>