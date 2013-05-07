<?php
$date = date("Y-m-d H:i:s", strtotime('- 1 month'));
$criteria = new CDbCriteria;
$criteria->condition = 'created > :date AND `author`.`group` = 0';
$criteria->params = array('date'=>$date);
$criteria->with = array('author');
echo $a1 = CommunityContent::model()->count($criteria).'<br>';
$criteria->condition .= ' AND uniqueness > 50';
echo $a2 = CommunityContent::model()->count($criteria).'<br>';

if ($a1 != 0)
    echo round(100*$a2 / $a1);
?>