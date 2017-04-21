<?php
/**
 * @var LiteController $this
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('family-user', array('kow'));
$this->pageTitle = 'Мои дети';
$user = \Yii::app()->user->getModel();
?>
<div class="notice-header clearfix notice-header--dialog">
    <div class="notice-header__item notice-header__item--left">
        <div class="notice-header__title">Мои дети</div>
    </div>
    <div class="notice-header__item notice-header__item--right"><a href="javascript:history.back();" class="notice-header__ico-close i-close i-close--sm"></a></div>
</div>
<div class="b-main_cont b-main_cont__wide">
    <!-- <div class="page-col_cont page-col_cont__in"> -->
        <family-user-iframe params='{"gender":<?=$user->gender?>}'></family-user-iframe>
    <!-- </div> -->
</div>
