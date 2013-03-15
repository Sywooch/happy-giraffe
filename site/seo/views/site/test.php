<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

Yii::import('site.seo.modules.promotion.components.*');
$p = new CRecipeLinking;

$criteria = new CDbCriteria;
$criteria->compare('section', 0);
$criteria->order = 'rand()';
$criteria->limit = 100;
$recipes = CookRecipe::model()->findAll($criteria);
foreach ($recipes as $recipe) {
    echo $recipe->title.'<br>';
    $p->recipe = $recipe;
    $p->page = Page::getPage('http://www.happy-giraffe.ru' . $recipe->getUrl());

    $keywords = $p->getFoundKeywords();

    foreach($keywords as $keyword)
        echo $keyword->name.'<br>';

    echo '<br>';
}

