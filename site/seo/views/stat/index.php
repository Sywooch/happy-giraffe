<?php
/**
 * @var $last_date string
 * @var $days int
 */

for ($i = 0; $i < $days; $i++) {
    $date = date("Y-m-d", strtotime(' - ' . $i . ' days', strtotime($last_date)));
    $data = array();


    echo UserStats::regCount($date).'<br>';
    echo UserStats::clubPostCount($date, UserGourp::USER).'<br>';
    echo UserStats::clubVideoCount($date, UserGourp::USER).'<br>';
    echo UserStats::clubCommentsCount($date, UserGourp::USER).'<br>';

    echo UserStats::blogPostCount($date, UserGourp::USER).'<br>';
    echo UserStats::blogVideoCount($date, UserGourp::USER).'<br>';
    echo UserStats::blogCommentsCount($date, UserGourp::USER).'<br>';


    break;
//    $data['new_users'] = Yii::app()->db->createCommand('select count(id) from community__contents
//    left join users ON users.id = community__contents.author_id
//    where created >= "' . $date . ' 00:00:00" AND created <= "' . $date . ' 23:59:59" AND type_id = 1')->queryScalar();
}