<?php $unread = MessageDialog::getUnreadMessagesCount($dialog['id']); ?>
<li<?php
    $class = '';
    if ($unread > 0) $class = 'new-messages';
    if ($dialog['id'] == $current_dialog_id) $class .= ' active';
    $class = trim($class);
    if (!empty($class))
        echo ' class="' . $class . '"';
    ?> id="dialog-<?php echo $dialog['id'] ?>">
    <input type="hidden" value="<?php echo $dialog['id'] ?>" class="dialog-id">
    <a href="#" class="remove"></a>

    <div class="img"><img src="<?php echo $dialog['user']->getAva('mini') ?>"/></div>
    <div class="status<?php if (!$dialog['user']->online) echo ' status-offline' ?>"><i
        class="icon"></i></div>
    <div class="name"><span><?php echo $dialog['user']->getFullName() ?></span></div>
    <div
        class="meta"<?php if ($unread == 0) echo ' style="display:none"'; ?>><?php echo $unread; ?></div>
</li>