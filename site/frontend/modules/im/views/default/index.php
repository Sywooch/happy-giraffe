<?php
foreach ($dialogs as $dialog) {
    echo CHtml::link($dialog->lastMessage->user->last_name.' : '.$dialog->lastMessage->text.'<br>',
        $this->createUrl('/im/default/dialog', array('id'=>$dialog->id)));
}