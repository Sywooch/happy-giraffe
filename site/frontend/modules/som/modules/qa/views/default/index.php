<?php
use site\frontend\modules\som\modules\qa\models\QaCategory;
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \CActiveDataProvider $dp
 * @var string $tab
 * @var string $categoryId
 * @var site\frontend\modules\som\modules\qa\models\QaCategory $category
 */
$this->pageTitle = 'Ответы';

$breadcrumbs = [
    'Главная' => ['/site/index'],
];

if (!is_null($categoryId))
{
    $breadcrumbs['Ответы'] = ['/som/qa/default/index'];
    $breadcrumbs[] = $category->title;

}
else {
    $breadcrumbs[] = 'Ответы';
}

?>

<div class="b-breadcrumbs" style="margin-left: 0">

<?php

$this->widget('zii.widgets.CBreadcrumbs', [
    'links'                => $breadcrumbs,
    'tagName'              => 'ul',
    'homeLink'             => FALSE,
    'separator'            => '',
    'activeLinkTemplate'   => '<li><a href="{url}">{label}</a></li>',
    'inactiveLinkTemplate' => '<li>{label}</li>',
]);

?>

</div>

<?php $this->renderPartial('/_search', array('query' => '')); ?>

<?php
$this->widget('site\frontend\modules\som\modules\qa\widgets\QuestionsFilterWidget', array(
    'tab' => $tab,
    'categoryId' => $categoryId,
    'htmlOptions' => ['class' => 'filter-menu filter-menu_mod visibles-lg'],
));
?>
</div>
<div class="clearfix"></div>

<?php

$class = 'questions questions-modification margin-t40';

if (! is_null($categoryId))
{
    if ($categoryId == QaCategory::PEDIATRICIAN_ID)
    {
        $class .= ' questions-pediatrician';
    }
}

$this->widget('LiteListView', array(
    'dataProvider'  => $dp,
    'itemView'      => '/_question',
    'category'      => $categoryId,
    'htmlOptions'   => array(
        'class' => $class
    ),
    'itemsTagName' => 'ul',
    'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
    'pager' => [
        'class'           => 'LitePagerDots',
        'prevPageLabel'   => '&nbsp;',
        'nextPageLabel'   => '&nbsp;',
        'showPrevNext'    => TRUE,
        'showButtonCount' => 5,
        'dotsLabel'       => '<li class="page-points">...</li>'
    ]
));
?>