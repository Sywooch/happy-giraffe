<?php
$criteria->addCondition('t.id = :id');
$criteria->params[':id'] = $data->id;
$data = CookRecipe::model()->find($criteria);

$this->renderPartial('_recipe', compact('data'));
