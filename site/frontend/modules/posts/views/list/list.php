<?php

$this->widget('LiteListView', array(
    'dataProvider' => $this->listDataProvider,
    'itemView' => '_view',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => array(
        'class' => 'LitePager',
        'prevPageLabel' => '&nbsp;',
        'nextPageLabel' => '&nbsp;',
        'showPrevNext' => true,
    ),
));
?>
