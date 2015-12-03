<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var site\frontend\modules\som\modules\qa\models\QaConsultation $consultation
 * @var \CActiveDataProvider $dp
 */
?>
<h1 class="heading-link-xxl"><?=$consultation->title?></h1>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '_question',
    'htmlOptions' => array(
        'class' => 'questions'
    ),
    'itemsTagName' => 'ul',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'viewData' => compact('consultation'),
    'pager' => array(
        'class' => 'LitePager',
        'maxButtonCount' => 10,
        'prevPageLabel' => '&nbsp;',
        'nextPageLabel' => '&nbsp;',
        'showPrevNext' => true,
    ),
));