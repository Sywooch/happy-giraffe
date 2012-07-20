<?php
$entity = ($this->modelName == null) ? get_class($this->model) : $this->modelName;
$entity_id = $this->model->primaryKey;
echo CHtml::link($this->template, '#', array(
    'class' => $this->cssClass,
    'onclick' => 'return RemoveWidget.removeConfirm(this, ' . CJavaScript::encode($this->author)
        . ', \'' . $entity . '\', ' . $entity_id . ', \'' . $this->callback
        . '\', '.CJavaScript::encode($this->getTitle($entity)).');'
));
?>