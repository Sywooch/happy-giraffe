<?php
/* @var $this Controller
 * @var $message array
 */
$user = User::getUserById($message['user_id']);
?><div class="dialog-message<?php if ($message['read_status'] == 0 && !$read) echo ' dialog-message-new-out' ?>" id="mess<?php echo $message['id'] ?>">
    <table>
        <tr>
            <td class="user">

                <div class="img"><img src="<?php echo $user->getMiniAva() ?>" /></div>
                <span><?php $user->first_name ?></span>

            </td>
            <td class="content">
                <?php echo $message['text'] ?>
            </td>
            <td class="meta">
                <span><?php echo MessageLog::GetFormattedTime($message['created']); ?></span>
            </td>
            <td class="actions">
                <a href="" class="remove"></a>
                <?php if ($message['user_id'] !== Yii::app()->user->getId() || isset($read)):?>
                    <a href="" class="claim"></a>
                <?php endif ?>

            </td>
        </tr>
    </table>
</div>