<div class="cook-title-cat">
    <h1 class="cook-title-cat-h1">
        <span class="cook-title-cat-h1-text">Моя кулинарная книга</span>
    </h1>
</div>
<?php
$this->widget('zii.widgets.CListView', array(
    'ajaxUpdate' => false,
    'dataProvider' => $dp,
    'itemView' => '_recipe',
    'summaryText' => 'Показано: {start}-{end} из {count}',
    'pager' => array(
        'class' => 'AlbumLinkPager',
    ),
    'template' => '{items}
            <div class="pagination pagination-center clearfix">
                {pager}
            </div>
        ',
));
