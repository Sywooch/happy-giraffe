<?php
$entity = get_class($this->model);
#TODO сделать как-то грамотно
if ($entity == 'SimpleRecipe' || $entity == 'MultivarkaRecipe')
    $entity = 'CookRecipe';

$entity_id = $this->model->primaryKey;
echo CHtml::link($this->template, '#', array(
    'class' => $this->cssClass,
    'onclick' => 'return RemoveWidget.removeConfirm(this, ' . CJavaScript::encode($this->author)
        . ', \'' . $entity . '\', ' . $entity_id . ', \'' . $this->callback
        . '\', '.CJavaScript::encode($this->getTitle($entity)).');'
));
?>