<?php
$criteria = new CDbCriteria;
$criteria->limit = 100;
$criteria->offset = 0;
$criteria->with = array('address');

$models = array(0);
$result = array();
while (!empty($models)) {
    $models = User::model()->findAll($criteria);

    foreach ($models as $model) {
        if (isset($model->address->region_id)) {
            if (isset($result[$model->address->region_id]))
                $result[$model->address->region_id]++;
            else
                $result[$model->address->region_id] = 1;
        }
    }

    $criteria->offset += 100;
}

arsort($result);

foreach ($result as $result_id=>$count)
    echo GeoRegion::model()->findByPk($result_id)->name . ' : ' . $count . '<br>';
?>