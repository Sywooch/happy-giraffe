<?php
/**
 * Author: alexk984
 * Date: 10.11.12
 */
$keywords = Yii::app()->db_keywords->createCommand()
    ->select('name')
    ->from('keywords')
    ->limit(100)
    ->order('id desc')
    ->queryColumn();

foreach($keywords as $keyword)
    echo $keyword."<br>";
