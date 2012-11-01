<?php
$criteria = new CDbCriteria;
$criteria->condition = 'created > "2012-10-01 00:00:00" AND
created < "2012-11-01 00:00:00" AND `author`.`group` = 0';
$criteria->with = array('author');
echo $a1 = CommunityContent::model()->count($criteria).'<br>';
$criteria->condition .= ' AND uniqueness > 50';
echo $a2 = CommunityContent::model()->count($criteria).'<br>';

if ($a1 != 0)
    echo round($a2 / $a1);
?>