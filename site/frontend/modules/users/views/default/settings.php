<?php
/**
 * @var site\frontend\modules\users\controllers\DefaultController $this
 */
$this->pageTitle = 'Мои настройки';
$cs = Yii::app()->clientScript;
$cs->registerAMD('user-settings', array('kow'));
?>
<div class="b-main_cont b-main_cont__broad">
    <div class="b-main_col-hold clearfix">
        <!--///// -->
        <!-- Основная колонка -->
        <div class="b-main_col-article">
            <user-settings></user-settings>
        </div>
        <!--/////-->
        <!-- Сайд бар  -->
        <aside class="b-main_col-sidebar visible-md"></aside>
    </div>
</div>