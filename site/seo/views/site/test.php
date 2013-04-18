<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$p = new YandexMetrica();
$keywords = $p->compareDates('2013-04-08', '2013-04-17');
?>
<table>
    <thead>
        <tr>
            <th>Ключевое слово</th>
            <th>20130408</th>
            <th>20130417</th>
            <th>Изменение %</th>
        </tr>
    </thead>
    <?php $i=0; ?>
    <?php foreach ($keywords as $keyword_id=>$stat): ?>
        <?php $diff = round(100 * ($stat[1] - $stat[0]) / ($stat[0] + $stat[1])) ?>
        <tr>
            <td><?php $k = Keyword::model()->findByPk($keyword_id); echo $k->name; ?></td>
            <td><?=$stat[0] ?></td>
            <td><?=$stat[1] ?></td>
            <td<?php if ($diff < -30) echo ' style="color:red;"' ?>><?= ($diff > 0) ? '+' . $diff : $diff ?> %</td>
        </tr>
        <?php $i++;if ($i > 1000) break; ?>
    <?php endforeach; ?>
</table>