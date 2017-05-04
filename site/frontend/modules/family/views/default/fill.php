<?php
/**
 * @var LiteController $this
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('family-user', array('kow'));
$this->pageTitle = 'Моя семья';
$user = \Yii::app()->user->getModel();
?>
<div class="b-main_cont b-main_cont__wide">
    <!-- <div class="page-col_cont page-col_cont__in"> -->
        <family-user params='{"gender":<?=$user->gender?>}'></family-user>
    <!-- </div> -->
</div>
