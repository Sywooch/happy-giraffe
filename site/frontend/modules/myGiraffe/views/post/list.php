<?php
$this->pageTitle = 'Мой Жираф';
?>
<!-- userAddRecord-->
<div class="userAddRecord clearfix  userAddRecord__blog">
    <div class="userAddRecord_hold">
        <div class="userAddRecord_tx"> Я хочу добавить</div>
        <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 1)); ?>" data-theme="transparent" title="Статью" class="userAddRecord_ico userAddRecord_ico__article"></a>
        <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 3)); ?>" data-theme="transparent" title="Фото" class="userAddRecord_ico userAddRecord_ico__photo"></a>
        <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 2)); ?>" data-theme="transparent" title="Видео" class="userAddRecord_ico userAddRecord_ico__video"></a>
        <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 5)); ?>" data-theme="transparent" title="Статус" class="userAddRecord_ico userAddRecord_ico__status"></a>
    </div>
</div>
<!-- /userAddRecord-->
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <aside class="b-main_col-sidebar visible-md">&nbsp;</aside>
        <?php
        $this->widget('LiteListView', array(
            'dataProvider' => $this->listDataProvider,
            'itemView' => 'site.frontend.modules.posts.views.list._view',
            'tagName' => 'div',
            'htmlOptions' => array(
                'class' => 'b-main_col-article'
            ),
            'itemsTagName' => 'div',
            'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
            'pager' => array(
                'class' => 'LitePager',
                'maxButtonCount' => 10,
                'prevPageLabel' => '&nbsp;',
                'nextPageLabel' => '&nbsp;',
                'showPrevNext' => true,
            ),
        ));
        ?>
    </div>
</div>