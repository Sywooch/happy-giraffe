<?php
/**
 * @var site\common\components\SphinxDataProvider $dp
 * @var string $query
 */
$this->pageTitle = 'Результаты поиска';

?>
<div class="b-col b-col--6 b-hidden-md">
    <div class="b-search-panel">
        <div class="b-search-result">
            <form class="b-search-result__form">
                <span class="b-search-result__close" onclick="location.href = '/'"></span>
                <input value="<?=$query?>" name="query" type="search" class="b-search-result__input" />
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