<?php $pal = Im::model()->GetDialogUser($id); ?>
<div class="dialog-list scroll" id="messages">
    <div class="inner-messages">
    <?php $this->renderPartial('_messages', array(
        'messages' => $messages
    )); ?>
    </div>
</div>