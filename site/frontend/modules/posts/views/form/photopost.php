<?php
$this->pageTitle = 'Добавление фотопоста';
$cs = Yii::app()->clientScript;
$cs->registerAMD('kow', array('kow'));
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <!--/////-->
        <!-- Основная колонка-->
        <div class="b-main_col-article">
            <post-photo-add params="id:<?= $id ? $id : 'false' ?>"></post-photo-add>
        </div>
    </div>
</div>