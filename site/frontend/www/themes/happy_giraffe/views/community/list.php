<?php

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $contents,
    'itemView' =>'_post',
    'summaryText' => 'Показано: {start}-{end} из {count}',
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => 'Страницы',
    ),
    'template' => '{items}
        <div class="pagination pagination-center clearfix">
            {summary}
            {pager}
        </div>
    ',
    'viewData' => array(
        'full' => false,
    ),
));
