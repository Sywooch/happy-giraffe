<?php
/**
 * @var string $query
 */
Yii::app()->clientScript->registerAMD('qa-search', array('ko' => 'knockout', 'QaSearch' => 'qa/search'), 'ko.applyBindings(new QaSearch("' . $query . '"), $(".b-filter-search").get(0));')
?>
<div class="b-filter-search">
    <form class="b-filter-search__form" action="<?=Yii::app()->createUrl('/som/qa/default/search/')?>" data-bind="submit: submit">
        <input name="query" type="search" placeholder="Найти вопрос" class="b-filter-search__input" data-bind="textInput: query"><span class="b-filter-search__submit">Найти вопрос</span>
    </form>
</div>