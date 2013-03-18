<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$criteria = new CDbCriteria;
$criteria->condition = 'date >= "2013-03-17"';
$criteria->order = 'rand()';
$criteria->limit = 10;
$links = InnerLink::model()->findAll($criteria);

foreach ($links as $link) {
    echo CHtml::link($link->page->getArticleTitle(), $link->page->url) . ' - ';
    echo $link->keyword->name . ' - ';
    echo CHtml::link($link->pageTo->getArticleTitle(), $link->pageTo->url) . '<br>';
}

$bad_list = array('реферат', 'база отдыха', 'аллергия', 'ВИДЕО', 'кроссворд');
foreach ($bad_list as $bad) {
    $criteria->compare('keyword.name', $bad, true);
    $criteria->with = array('keyword');
    $links = InnerLink::model()->findAll($criteria);
    foreach ($links as $link)
        echo $link->keyword->name . '<br>';

    echo '<br><br>';
}
