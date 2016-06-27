<?php

$this->widget('LiteListView', array(
    'dataProvider' => $this->getDataProvider(),
    'itemView'     => 'site.frontend.modules.som.modules.activity.widgets.views._view',
    'tagName'      => 'div',
    'itemsTagName' => FALSE,
    'template'     => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => [
        'class'          => 'LitePagerDots',
        'prevPageLabel'   => '&nbsp;',
        'nextPageLabel'   => '&nbsp;',
        'showPrevNext'    => TRUE,
        'showButtonCount' => 3,
        'dotsLabel'       => '<li class="page-points">...</li>'
    ]
));

?>