<?php foreach ($messages as $message): ?>
<?php $this->renderPartial('_message', array(
        'message' => $message
    )); ?>
<?php endforeach; ?>