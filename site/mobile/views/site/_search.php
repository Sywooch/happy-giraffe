<?php
$criteria->addCondition('t.id = :id');
$criteria->params[':id'] = $data->id;
$c = CommunityContent::model()->full()->find($criteria);
if(!$c)
    return;
$name = Yii::app()->search->buildExcerpts(array($c->title), $search_index, $search_text);
$c->title = $name[0];
$text = Yii::app()->search->buildExcerpts(array($c->preview), $search_index, $search_text);
$c->preview = $text[0];

$this->renderPartial('//community/_post', array(
    'full' => false,
    'data' => $c,
));