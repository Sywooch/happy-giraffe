<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 * @var $parser RouteChecker
 */

?>
<table>
    <thead>
    <tr>
        <td></td>
        <?php foreach ($parser->cities as $city): ?>
            <td><?=$city[0] ?></td>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($parser->keywords as $keyword_id => $keyword): ?>
        <tr>
            <td><?=$keyword ?></td>
            <?php foreach ($parser->cities as $city_id => $city): ?>
                <td><?=$parser->getValue($city_id, $keyword_id) ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>