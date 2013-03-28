<?php for ($i = $messages->itemCount - 1; $i >= 0; $i--): ?>
<?php $this->renderPartial('_message', array('message' => $messages->data[$i])); ?>
<?php endfor; ?>