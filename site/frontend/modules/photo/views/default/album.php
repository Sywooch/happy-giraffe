<?php
$this->pageTitle = 'Фотоальбом' ;

$this->breadcrumbs = array(
    'мои фото' => array('/photo/default/index'),
    'Фотоальбом',
);
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-album', array('kow'));
?>
<photo-album params="userId: <?= $userId ?>, albumId: <?= $id ?>"></photo-album>