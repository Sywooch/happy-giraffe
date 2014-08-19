<?php
/**
 * @var LiteController $this
 * @var GeoCity $data
 */
?>

<li class="map-route-list_li">
    <a class="map-route-list_a" href="<?=$this->createUrl('city', array('cityId' => $data->id))?>">
        <div class="map-route-list_city"><?=$data->name?></div>
        <div class="map-route-list_region"><?=$data->region->name?></div>
    </a>
</li>