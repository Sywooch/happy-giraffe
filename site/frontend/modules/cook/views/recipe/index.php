<?php

$this->breadcrumbs = array(
    'Кулинария' => array('/cook'),
    'Рецепты'
);


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
