<?php

use site\frontend\modules\som\modules\qa\models\qaTag\Enum;

/**
 * @var string $query
 * @var string $tagId ID выбранного тега
 */

\Yii::app()->clientScript->registerAMD(
    'qa-search',
    [
        'ko'        => 'knockout',
        'QaSearch'  => 'qa/search'
    ],
    'ko.applyBindings(new QaSearch("' . $query . '"), $(".js-filter-search").get(0));'
);


$tagsIdList = [
    Enum::LESS_THAN_YEAR_ID,
    Enum::MORE_THAN_YEAR_ID,
    Enum::PRESCHOOL_ID,
    Enum::SCHOOLKID_ID
];

\Yii::app()->clientScript->registerAMD(
    'qa-age-dropdown',
    [
        'ko'            => 'knockout',
        'QaAgeDropdown' => 'qa/age-dropdown'
    ],
    'ko.applyBindings(new QaAgeDropdown(' . CJSON::encode(['tagsIdList' => $tagsIdList, 'selectedTagId' => $tagId]) . '), $(".js-filter-dropdown").get(0));'
);

?>

<div class="b-margin--right_20">
    <div class="b-filter-dropdown js-filter-dropdown">
        <a href="javascript:void(0);" data-beloworigin="true" data-activates="dropdown-menu" class="dropdown-button b-filter-dropdown__menu b-filter-dropdown__menu--ico"></a>
        <ul id="dropdown-menu" class="b-filter-dropdown__content">
            <span class="b-filter-dropdown__title">Возраст</span>

            <!-- ko foreach: items -->

            <li class="b-filter-dropdown__item">
                <input type="radio" data-bind="attr: { id: 'filled-in-' + $index(), checked: tagId == $root.selectedTagId }" name="ages" class="material-theme-radio filled-in" />
                <label data-bind="attr: { for: 'filled-in-' + $index() }, click: $root.onSelected.bind(event)">
                    <span class="text--grey" data-bind="text: label, attr: { tagId: tagId }"></span>
                </label>
            </li>

            <!-- /ko -->

        </ul>
    </div>
    <div class="b-filter-search js-filter-search">
        <form class="b-filter-search__form" action="<?=Yii::app()->createUrl('/som/qa/default/pediatricianSearch')?>" data-bind="submit: submit">
            <div class="js-search-active b-filter-search__panel"><span class="b-filter-search__submit"></span><span class="b-filter-search__close"></span>
                <input name="query" type="search" placeholder="Найти вопрос" class="b-filter-search__input" data-bind="textInput: query" />
            </div>
        </form>
    </div>
</div>
