<?php echo CHtml::link('<i class="icon"></i>', '#', array(
    'class' => 'remove',
    'onclick' => 'return RemoveWidget.removeConfirm(this, ' . CJavaScript::encode($this->author) . ');'
)); ?>