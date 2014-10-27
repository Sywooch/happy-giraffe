<?php
/**
 * @var PhotoController $this
 * @var $json
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-albums', array('kow'));
?>
<photo-albums  params="userId: <?= $userId ?>"></photo-albums>
