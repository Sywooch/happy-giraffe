<?php
$criteria = new CDbCriteria;
$criteria->limit = 100;
$criteria->offset = 0;
$criteria->with = array('userAddress');

$models = array(0);
$result = array();
while (!empty($models)) {
    $models = User::model()->findAll($criteria);

    foreach ($models as $model) {
        if (isset($model->userAddress->region_id)) {
            if (isset($result[$model->userAddress->region_id]))
                $result[$model->userAddress->region_id]++;
            else
                $result[$model->userAddress->region_id] = 1;
        }
    }

    $criteria->offset += 100;
}

arsort($result);

foreach ($result as $result_id=>$count)
    echo GeoRegion::model()->findByPk($result_id)->name . ' : ' . $count . '<br>';
?>