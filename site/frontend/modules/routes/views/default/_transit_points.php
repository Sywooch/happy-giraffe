<?php
/**
 * Author: alexk984
 * Date: 05.02.13
 *
 * @var $route Route
 * @var $points array
 * @var $texts array
 */

?><h2><?=$texts[2] ?></h2>
<table class="map-route-table">
    <colgroup><col class="map-route-table_col1">
        <col class="map-route-table_col2">
        <col class="map-route-table_col3">
    </colgroup><thead class="map-route-table_thead">
<tr>
    <td class="map-route-table_thead-td"></td>
    <td class="map-route-table_thead-td">Пункт / регион</td>
    <td class="map-route-table_thead-td">Время участка </td>
    <td class="map-route-table_thead-td">Время в пути</td>
    <td class="map-route-table_thead-td">Участок, км</td>
    <td class="map-route-table_thead-td">Всего, км</td>
</tr>
</thead>
    <tbody>
    <?php foreach ($points as $index => $point): ?>
        <tr class="map-route-table_tr">
            <td class="map-route-table_td">
                <div class="map-route-table_hold">
                    <?php if ($index == 0):?>
                        <div class="map-route-start">A</div>
                    <?php else: ?>
                        <?php if ($index == (count($points) - 1)):?>
                            <div class="map-route-start">B</div>
                        <?php else: ?>
                            <div class="map-route-point"><?=$point['num'] ?></div>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </td>
            <td class="map-route-table_td textalign-l">
                <div class="map-route-table_hold">
                    <strong><?=$point['city']->name ?></strong> <br>
                    <?=$point['city']->region->name ?>
                </div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold">
                    <?=$point['time'] ?>
                </div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold">
                    <?=$point['summary_time'] ?>
                </div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold">
                    <?=$point['distance'] ?>
                </div>
            </td>
            <td class="map-route-table_td">
                <div class="map-route-table_hold">
                    <?=$point['summary_distance'] ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
