<?php $this->renderPartial('_search_form',array()); ?>
<?php
$this->widget('zii.widgets.CListView', array(
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
