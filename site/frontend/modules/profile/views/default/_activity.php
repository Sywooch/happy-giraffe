<?php
$dataProvider = new CActiveDataProvider('CommunityContents', array(
    'criteria' => array(
        'condition' => 'removed = 0 and album_id = :album_id',
        'params' => array(':album_id' => $model->id),
    ),
    'pagination' => array('pageSize' => 20)
));