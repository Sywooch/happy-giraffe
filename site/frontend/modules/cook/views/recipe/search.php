<?php
    $this->widget('zii.widgets.CListView', array(
        'ajaxUpdate' => false,
        'dataProvider' => $dataProvider,
        'itemView' => '_search',
        'summaryText' => 'Показано: {start}-{end} из {count}',
        'pager' => array(
            'class' => 'AlbumLinkPager',
        ),
        'template' => '{items}
                <div class="pagination pagination-center clearfix">
                    {pager}
                </div>
            ',
        'viewData' => array(
            'search_text' => $text,
            'criteria' => $criteria,
        )
    ));
