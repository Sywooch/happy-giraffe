<?php
$entity = get_class($this->model);
$entity_id = $this->model->primaryKey;
echo CHtml::link('<i class="icon"></i>', '#', array(
    'class' => 'remove',
    'onclick' => 'return RemoveWidget.removeConfirm(this, ' . CJavaScript::encode($this->author)
        . ', \'' . $entity . '\', ' . $entity_id . ', \'' . $this->callback
        . '\', '.CJavaScript::encode($this->getTitle($entity)).');'
));
?>