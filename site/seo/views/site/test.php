<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$keywords = 1;
$criteria = new CDbCriteria;
$criteria->order = 'wordstat desc';
$criteria->limit = 3000;

$keywords = Keyword::model()->findAll($criteria);

foreach ($keywords as $keyword) {
    $new_name = WordstatQueryModify::prepareForSave($keyword->name);
    if ($new_name != $keyword->name) {
        echo $new_name.' ---- '.CHtml::encode($keyword->name);
        $model2 = Keyword::model()->findByAttributes(array('name' => $new_name));
        if ($model2 !== null) {
            try {
                $keyword->delete();
            } catch (Exception $err) {
                echo $err->getMessage();
            }
        } else {
            $keyword->name = $new_name;
            try {
                $keyword->save();
            } catch (Exception $err) {
                echo "err_s\n";
            }
        }
    }
}