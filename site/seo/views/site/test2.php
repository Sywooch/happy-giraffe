<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

Yii::import('site.common.models.mongo.*');
Yii::import('site.frontend.helpers.*');
$criteria = new EMongoCriteria();
$criteria->setLimit(230);
$criteria->setSort(array('visits' => EMongoCriteria::SORT_DESC));
$pages = PageStatistics::model()->findAll($criteria);

?>
<table>
    <thead>
        <tr>
            <th>Url</th>
            <th>Название статьи</th>
            <th>20130408</th>
            <th>20130418</th>
            <th>Изменение %</th>
        </tr>
    </thead>
    <?php foreach ($pages as $page): ?>
        <?php if (!isset($page->date_visits['2013-04-18'])){var_dump($page);Yii::app()->end();} ?>
        <?php
        if ($page->date_visits['2013-04-15'] == 0)
            $diff = 100;
        else
            $diff = round(100 * ($page->date_visits['2013-04-18'] - $page->date_visits['2013-04-15'])
            / $page->date_visits['2013-04-15'])
        ?><tr>
            <td><?= $page->url ?></td>
            <td><?= $page->getTitle() ?></td>
            <td><?=$page->date_visits['2013-04-15'] ?></td>
            <td><?=$page->date_visits['2013-04-18'] ?></td>
            <td><?=$diff ?></td>
        </tr>
    <?php endforeach; ?>
</table>