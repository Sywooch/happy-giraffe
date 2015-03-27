<?php
$this->pageTitle = 'Добавление статуса';
$cs = Yii::app()->clientScript;
$cs->registerAMD('kow', array('kow'));
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <post-status-add></post-status-add>
        </div>
    </div>
</div>