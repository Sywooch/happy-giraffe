<?php
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-single', array('kow'));
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <post-photo-add></post-photo-add>
        </div>
    </div>
</div>