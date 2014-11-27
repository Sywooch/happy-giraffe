<?php
/**
 * @author Никита
 * @date 17/11/14
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('family-user', array('kow'));
?>
<div class="page-col page-col__user">
    <div class="page-col_cont page-col_cont__in">
        <family-user></family-user>
    </div>
</div>
