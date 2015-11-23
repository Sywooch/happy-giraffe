<?php
/**
 * @var site\common\components\SphinxDataProvider $dp
 * @var string $query
 */

Yii::app()->clientScript->registerAMD('qa-search', array('ko' => 'knockout', 'QaSearch' => 'qa/search'), 'ko.applyBindings(new QaSearch("' . $query . '"), $(".info-search").get(0));')
?>

<div class="info-search">
    <form data-bind="submit: submit">
        <input type="text" placeholder="Найти ответ" name="query" class="info-search_itx info-search_normal info-search_tablet info-search_mobile" data-bind="textInput: query">
    </form>
    <button class="info-search_btn" data-bind="click: clear, css: { active: query().length > 0 }"></button>
</div>
<div class="only-mobile"><a href="#AskWidget" class="consult-specialist_btn btn btn-success btn-xl popup-a">Задать вопрос</a></div>
<?php if (empty($query) || $dp->totalItemCount == 0): ?>
    <p>Ничего не найдено</p>
<?php else: ?>
<div class="search-heading">
    <div class="hash-tag-big"></div>
    <div class="heading-link-xxl"> <?=$query?>&nbsp;<span><?=$dp->totalItemCount?></span></div>
    <div class="clearfix"></div>
</div>
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
<?php endif; ?>

