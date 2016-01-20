<?php
/**
 * @var \site\frontend\modules\posts\controllers\ListController $this
 */
$this->pageTitle = 'Buzz';
$this->metaNoindex = true;
?>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $this->listDataProvider,
    'itemView' => '_view',
    'tagName' => 'div',
    'htmlOptions' => array(
        'class' => 'b-main_col-article'
    ),
    'itemsTagName' => 'div',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => array(
        'class' => 'LitePager',
        'maxButtonCount' => 10,
        'prevPageLabel' => '&nbsp;',
        'nextPageLabel' => '&nbsp;',
        'showPrevNext' => true,
    ),
));