<?php
/**
 * @var LiteController $this
 * @var Route $data
 */
?>

<li class="map-route-list_li">
    <a class="map-route-list_a" href="<?=$data->getUrl()?>">
        <div class="map-route-list_city"><?=$data->cityFrom->name?></div>
        <div class="map-route-list_region"><?=$data->cityFrom->region->name?> <span class="map-route-list_city"> -</span></div>
        <div class="map-route-list_city"><?=$data->cityTo->name?></div>
        <div class="map-route-list_region"><?=$data->cityTo->region->name?> </div>
    </a>
</li>