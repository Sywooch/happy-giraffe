<?php
/**
 * @var string $query
 */
Yii::app()->clientScript->registerAMD('qa-search', array('ko' => 'knockout', 'QaSearch' => 'qa/search'), 'ko.applyBindings(new QaSearch("' . $query . '"), $(".info-search").get(0));')
?>

<div class="info-search">
    <form data-bind="submit: submit" action="<?=Yii::app()->createUrl('/som/qa/default/search/')?>">
        <input type="text" placeholder="Найти ответ" name="query" class="info-search_itx info-search_normal info-search_tablet info-search_mobile" data-bind="textInput: query">
    </form>
    <button class="info-search_btn" data-bind="click: clear, css: { active: query().length > 0 }"></button>
</div>