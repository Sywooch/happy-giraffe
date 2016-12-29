<?php
/**
 * @var site\common\components\SphinxDataProvider $dp
 * @var string $query
 */
$this->pageTitle = 'Результаты поиска';

$breadcrumbs = [
    'Главная' => ['/site/index'],
    'Результаты поиска'
];

?>
<div class="b-col b-col--6 b-hidden-md">
	<div class="b-breadcrumbs b-breadcrumbs--theme-default">
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', [
            'links'                => $breadcrumbs,
            'tagName'              => 'ul',
            'homeLink'             => FALSE,
            'separator'            => '',
            'htmlOptions'          => ['class' => 'b-breadcrumbs__list'],
            'activeLinkTemplate'   => '<li class="b-breadcrumbs__item"><a href="{url}" class="b-breadcrumbs__link">{label}</a></li>',
            'inactiveLinkTemplate' => '<li class="b-breadcrumbs__item">{label}</li>',
        ]);
        ?>
    </div>
    <div class="b-search-panel">
        <div class="b-search-result">
            <form class="b-search-result__form">
                <input value="<?=$query?>" name="query" type="search" class="b-search-result__input" />
                <input name="categoryId" type="hidden" value="124">
            </form>
        </div>
    </div>
</div>
<?php if (empty($query) || $dp->totalItemCount == 0): ?>
    <div class="b-col b-col--6 b-col-sm--10 b-col-xs">
        <div class="b-search">
            <div class="b-search__ico"></div>
            <div class="b-search__text">Вопросов не найдено</div>
        </div>
    </div>
<?php else:?>
<?php
$this->widget('LiteListView', array(
    'dataProvider'  => $dp,
    'itemView'      => '/_new_question',
    'htmlOptions'       => [
        'class' => 'b-col b-col--6 b-col-sm--10 b-col-xs',
    ],
    'itemsTagName'  => 'ul',
    'itemsCssClass' => 'b-answer b-answer--theme-pediator',
    'template'      => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
));
?>
<?php endif; ?>