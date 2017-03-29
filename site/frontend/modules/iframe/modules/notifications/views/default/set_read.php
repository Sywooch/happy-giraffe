<?php
/**
 * @var $model Notification
 * @var $check bool
 */
if (!$read){
?>
<div class="user-notice-list_check">
    <a href="javascript:;" class="user-notice-list_check-a powertip" onclick="UserNotification.read(this, '<?=$model->getId() ?>', <?=$model->count ?>)" title="Прочитано"></a>
</div>
<div class="user-notice-list_markread" style="display: none;">
    <div class="user-notice-list_markread-hold">
        <span class="color-gray">Прочитано</span> <br>
        <a href="javascript:;" class="a-pseudo" onclick="UserNotification.cancel(this, '<?=$model->getId() ?>', <?=$model->count ?>)">Отменить?</a>
    </div>
</div><?php } ?>