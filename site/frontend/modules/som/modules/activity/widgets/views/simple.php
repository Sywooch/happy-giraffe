<?php
$this->widget('LiteListView', array(
    'dataProvider' => $this->getDataProvider(),
    'itemView' => 'site.frontend.modules.som.modules.activity.widgets.views._view',
    'tagName' => 'div',
    'itemsTagName' => false,
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