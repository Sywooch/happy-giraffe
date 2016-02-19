<?php
$this->pageTitle = 'Идеи';
$cs = Yii::app()->clientScript;
$cs->registerAMD('kow', array('kow'));
?>
<div class="b-main_cont ideas-cont">
    <h1 class="heading-link-xxl"><?= $this->pageTitle ?></h1>

    <div class="b-crumbs">
        <div class="b-crumbs_tx">Я здесь:</div>
        <ul class="b-crumbs_ul">
            <li class="b-crumbs_li"><a href="#" class="b-crumbs_a">Ответы</a></li>
            <li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">Обсуждаем проблемы ГВ</span></li>
        </ul>
    </div>
    <div class="b-main_col-article">
        <ideas-line params=""></ideas-line>
    </div>
</div>
