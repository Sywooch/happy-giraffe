<?php
$c = CookRecipe::model()->find($criteria);
if(!$c)
    return;
$name = Yii::app()->search->buildExcerpts(array($c->title), 'recipe', $search_text);
$c->title = $name[0];
echo $c->title;
echo $c->text;
