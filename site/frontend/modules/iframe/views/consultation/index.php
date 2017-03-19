<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\ConsultationController $this
 * @var site\frontend\modules\som\modules\qa\models\QaConsultation $consultation
 * @var \CActiveDataProvider $dp
 */
$this->pageTitle = $this->consultation->title;
?>
<h1 class="heading-link-xxl"><?=$this->consultation->title?></h1>

<?php
$this->widget('LiteListView', array(
    'dataProvider' => $dp,
    'itemView' => '/_question',
    'htmlOptions' => array(
        'class' => 'questions',
    ),
    'itemsTagName' => 'ul',
    'itemsCssClass' => 'q-consult',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
));