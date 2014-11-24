<?php
$this->pageTitle = 'Блог - ' . $this->user->fullName;
$this->metaNoindex = true;
$this->breadcrumbs = array(
    '<span class="ava ava__small">' . CHtml::image($this->user->avatarUrl, $this->user->fullName, array('class' => 'ava_img')) . "</span>" => $this->user->profileUrl,
    'Блог',
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