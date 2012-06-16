<?php
$criteria->addCondition('t.id = :id');
if (isset($data['id'])) {
    $criteria->params[':id'] = $data['id'];
    if (isset($type) && $type !== null)
        $criteria->compare('type', $type);
    $data = CookRecipe::model()->find($criteria);

    if ($data)
        $this->renderPartial('_recipe', compact('data'));
}