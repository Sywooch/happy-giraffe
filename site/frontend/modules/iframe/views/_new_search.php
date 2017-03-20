<?php
/**
 * @var string $query
 */
Yii::app()->clientScript->registerAMD('qa-search', array('ko' => 'knockout', 'QaSearch' => 'qa/search'), 'ko.applyBindings(new QaSearch("' . $query . '"), $(".b-filter-search").get(0));')
?>
<div class="b-filter-search">
    <form class="b-filter-search__form b-filter-search-iframe__form" action="<?=Yii::app()->createUrl('/som/qa/default/pediatricianSearch')?>" data-bind="submit: submit">
        <div class="b-filter-year-iframe">
            <span class="b-filter-year-iframe__icon"></span>
            <div class="b-filter-year-iframe-menu">
                <?php $this->renderPartial('/_sidebar/new_menu');?>
            </div>
        </div>
        <span class="b-filter-search__submit b-filter-search-iframe__submit"></span>
        <span class="b-filter-search__close"></span>
        <input name="query" type="search" placeholder="Найти вопрос" class="b-filter-search__input b-filter-search-iframe__input" data-bind="textInput: query">
    </form>
</div>