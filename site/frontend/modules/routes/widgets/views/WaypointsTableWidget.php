<?php
/**
 * @var $this WaypointsTableWidget
 */
?>

<div class="heading-xl visible-md-block"><?=$this->route->texts[2]?></div>
<table class="map-route-table visible-md-table">
    <colgroup>
        <col class="map-route-table_col1">
        <col class="map-route-table_col2">
        <col class="map-route-table_col3">
        <col>
        <col>
        <col>
        <col>
    </colgroup>
    <thead class="map-route-table_thead">
    <tr>
        <td class="map-route-table_thead-td"></td>
        <td class="map-route-table_thead-td textalign-l">Пункт / регион</td>
        <td class="map-route-table_thead-td">Трасса</td>
        <td class="map-route-table_thead-td">Время участка </td>
        <td class="map-route-table_thead-td">Время в пути</td>
        <td class="map-route-table_thead-td">Участок, км     </td>
        <td class="map-route-table_thead-td">Всего, км</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->route->intermediatePoints as $point): ?>
        <tr class="map-route-table_tr">
            <td class="map-route-table_td">
                <div class="map-route-table_hold">
                    <div class="map-route-start"></div>
                </div>
            </td>
            <td class="map-route-table_td textalign-l">
                <div class="map-route-table_hold"><strong><?=$point['city']->name?></strong><br><?=$point['city']->region->name?></div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold"><strong>M8</strong></div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold"><?=$point['time']?></div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold"><?=$point['summary_time']?></div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold"><?=$point['distance']?></div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold"><?=$point['summary_distance']?></div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>