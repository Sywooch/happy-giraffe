<?php
$this->pageTitle = 'Мой Жираф';
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <aside class="b-main_col-sidebar visible-md">
            
        </aside>
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