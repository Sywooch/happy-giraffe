<?php
$this->pageTitle = 'Создание фотоальбома' ;

$this->breadcrumbs = array(
    'мои фото' => array('/photo/default/create'),
    'Создание фотоальбома',
);
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-albums-create', array('kow'));
?>
<photo-albums-create></photo-albums-create>
