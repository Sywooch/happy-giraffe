<?php
$this->pageTitle = $this->forum->title;
$this->metaNoindex = true;
$this->breadcrumbs = array(
    $this->club->section->title => $this->club->section->getUrl(),
    $this->club->title => $this->club->getUrl(),
    (isset($this->club->communities) && count($this->club->communities) > 1) ? $this->forum->title : 'Форум' => $this->forum->getUrl()
);
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        $this->widget('LiteListView', array(
            'dataProvider' => $this->listDataProvider,
            'itemView' => '_view',
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
        <aside class="b-main_col-sidebar visible-md"></aside>
    </div>
</div>