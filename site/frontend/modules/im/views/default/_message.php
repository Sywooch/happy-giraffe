<?php
/* @var $this Controller
 * @var $message MessageLog
 */
?><div class="mess_content<?php if ($message->read_status == 0 && !isset($read)) echo ' unread' ?>" id='mess<?php echo $message->id ?>'>
    <?php echo $message->user->first_name ?> : <?php echo $message->text ?> : <?php echo $message->created ?></div>