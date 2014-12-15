<?php
/**
 * @var LiteController $this
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('family-user', array('kow'));
$this->pageTitle = 'Моя семья';
?>
<div class="b-main_cont b-main_cont__wide">
    <!-- <div class="page-col_cont page-col_cont__in"> -->
        <family-user></family-user>
    <!-- </div> -->
</div>
