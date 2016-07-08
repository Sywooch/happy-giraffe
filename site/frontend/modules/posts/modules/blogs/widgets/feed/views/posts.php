<?php
		
/**
 * @var $this \site\frontend\modules\posts\modules\blogs\widgets\feed\FeedWidget 
 */

$this->widget('LiteListView', [
    'dataProvider' => $this->getListDataProvider(),
    'viewData'     => [
        'maxTextLength' => $maxTextLength
    ],
    'itemView'     => '_post',
    'tagName'      => 'div',
    'htmlOptions'  => [
        'class' => 'b-main_col-article'
    ],
    'itemsTagName' => 'div',
    'template'     => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => [
        'class'           => 'LitePagerDots',
        'prevPageLabel'   => '&nbsp;',
        'nextPageLabel'   => '&nbsp;',
        'showPrevNext'    => TRUE,
        'showButtonCount' => 5,
        'dotsLabel'       => '<li class="page-points">...</li>' 
    ]
]);

?>