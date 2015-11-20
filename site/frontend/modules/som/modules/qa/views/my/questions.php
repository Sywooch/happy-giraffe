<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\MyController $this
 * @var \CActiveDataProvider $dp
 */
?>
<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '/default/_question',
    'htmlOptions' => array(
        'class' => 'questions'
    ),
    'itemsTagName' => 'ul',
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