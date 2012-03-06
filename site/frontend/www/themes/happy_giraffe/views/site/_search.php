<?php
$criteria->addCondition('t.id = :id');
$criteria->params[':id'] = $data->id;
$c = CommunityContent::model()->full()->find($criteria);
$name = Yii::app()->search->buildExcerpts(array($c->name), $search_index, $search_text);
$c->name = $name[0];
$text = Yii::app()->search->buildExcerpts(array($c->content->text), $search_index, $search_text);
$c->content->text = $text[0];

$this->renderPartial('//community/_post', array(
    'full' => false,
    'data' => $c
));
?>
