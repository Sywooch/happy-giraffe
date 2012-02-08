<?php foreach ($messages as $message): ?>
<?php if ($message['user_id'] !== Yii::app()->user->getId())
        $read = 1; else $read = 0;?>
<?php $this->renderPartial('_message', array(
        'message' => $message,
        'read'=>$read
    )); ?>
<?php endforeach; ?>