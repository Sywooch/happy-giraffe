<?php
/**
 * @var $this LiteController
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('subscription', array('kow'));
?>

<div class="layout-loose_hold clearfix">
    <div class="b-main">
        <div class="b-main_cont b-main_cont__wide">
            <div class="mygiraffe b-main_col-hold clearfix"><a href="javascript:void(0)" class="ico-close6" onclick="window.history.back()">×</a>
                <subscription></subscription>
            </div>
        </div>
    </div>
</div>