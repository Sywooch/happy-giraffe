<?php
		
/**
 * @var \site\frontend\modules\posts\modules\blogs\widgets\feed\FeedWidget $this
 */

$this->widget('LiteListView', [
    'dataProvider' => $this->getListDataProvider(),
    'viewData'     => ['maxTextLength' => $maxTextLength],
    'itemView'     => '_post',
    'tagName'      => 'div',
    'htmlOptions'  => [
        'class' => 'b-main_col-article'
    ],
    'itemsTagName' => 'div',
    'template'     => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => [
        'class'          => 'LitePager',
        'maxButtonCount' => 10,
        'prevPageLabel'  => '&nbsp;',
        'nextPageLabel'  => '&nbsp;',
        'showPrevNext'   => TRUE,
        // 'showButtonCount' => 4
    ]
]);

?>