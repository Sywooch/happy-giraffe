<?php
$this->pageTitle = 'Добавление идеи';
$cs = Yii::app()->clientScript;
$cs->registerAMD('kow', array('kow'));
?>
<div class="b-main_cont">
    <div class="postAdd b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <idea-add params="id:<?= $id ? $id : 'false' ?>"></idea-add>
        </div>
    </div>
</div>