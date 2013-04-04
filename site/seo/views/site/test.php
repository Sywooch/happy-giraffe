<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$criteria = new CDbCriteria;
$criteria->limit = 200;
$criteria->condition = 'status = 2';
$statuses = KeywordStatus::model()->findAll($criteria);
echo 'Bad keywords <br><br>';
foreach ($statuses as $status) {
    echo $status->keyword->name.'<br>';
}

$criteria->condition = 'status = 1';
$statuses = KeywordStatus::model()->findAll($criteria);
echo 'Good keywords <br><br>';
foreach ($statuses as $status) {
    echo $status->keyword->name.'<br>';
}


$criteria->condition = 'status = 0';
$statuses = KeywordStatus::model()->findAll($criteria);
echo 'Undefined keywords <br><br>';
foreach ($statuses as $status) {
    echo $status->keyword->name.'<br>';
}
