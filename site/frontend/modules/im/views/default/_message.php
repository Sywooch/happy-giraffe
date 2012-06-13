<?php
/* @var $this Controller
 * @var $message array
 */
$user = User::getUserById($message['user_id']);
if (!isset($class))
    $class = '';
?><div class="dialog-message<?php if ($message['read_status'] == 0 && !$read) echo ' dialog-message-new-in'
?> <?php echo $class ?>" id="Message_<?php echo $message['id'] ?>">
    <table>
        <tr>
            <td class="user">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $user, 'small'=>true, 'size'=>'small')); ?>
            </td>
            <td class="content">
                <div class="name"><?php echo CHtml::encode($user->first_name); ?></div>
                <?php echo $message['text'] ?>
            </td>
            <td class="date"><?php echo HDate::GetFormattedTime($message['created'], '<br/>'); ?></td>
            <td class="actions">
                <a href="" class="remove"></a>
            </td>
        </tr>
    </table>
</div>