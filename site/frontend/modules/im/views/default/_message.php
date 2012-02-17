<?php
/* @var $this Controller
 * @var $message array
 */
$user = Im::model()->getUser($message['user_id']);
if (!isset($class))
    $class = '';
?><div class="dialog-message<?php if ($message['read_status'] == 0 && !$read) echo ' dialog-message-new-out'
?> <?php echo $class ?>" id="MessageLog_<?php echo $message['id'] ?>">
    <table>
        <tr>
            <td class="user">
                <div class="img"><img src="<?php echo $user->getMiniAva() ?>" /></div>
                <div class="date"><?php echo MessageLog::GetFormattedTime($message['created']); ?></div>
            </td>
            <td class="content">
                <?php echo $message['text'] ?>
            </td>
            <td class="actions">
                <a href="" class="remove"></a>
            </td>
        </tr>
    </table>
</div>