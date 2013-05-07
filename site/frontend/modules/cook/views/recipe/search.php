<?php
$this->renderPartial('_search_form',array());

$this->widget('zii.widgets.CListView', array(
    'cssFile'=>false,
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
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
