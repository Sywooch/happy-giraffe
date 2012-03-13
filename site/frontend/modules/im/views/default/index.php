<?php
/* @var $this Controller
 * @var $dialogs MessageDialog[]
 */
?>
<div class="dialog-list">
    <?php foreach ($dialogs as $dialog): ?>
    <div class="dialog-message dialog-message-<?php
        if ($dialog->unreadByMe) echo 'new-in';
        elseif ($dialog->unreadByPal) echo 'new-out';
        else {
            echo ($dialog->lastMessage->isMessageSentByUser()) ? 'out' : 'in';
        }
        ?>" id="MessageDialog_<?php echo $dialog->id; ?>">
        <input type="hidden" value="<?php echo $this->createUrl('/im/default/dialog', array('id' => $dialog->id)) ?>"
               class="dialog_url">
        <input type="hidden" value="<?php echo $dialog->id ?>"
               class="dialog_id">
        <table>
            <tr>
                <td class="user">
                    <?php $this->widget('AvatarWidget', array('user' => Im::model()->GetDialogUser($dialog->id))); ?>
                    <span><?php echo Im::model()->GetDialogUser($dialog->id)->getFullName() ?></span>
                </td>
                <td class="message-icon">
                    <div class="icon"></div>
                    <div class="date">
                        <span><?php echo HDate::GetFormattedTime($dialog->lastMessage->created, '<br/>'); ?></span>
                    </div>
                </td>
                <td class="content">
                    <?php echo CHtml::decode($dialog->lastMessage->text) ?>
                </td>
                <td class="actions">

                    <a href="" class="remove"></a>
                    <a href="" class="claim"></a>

                </td>
            </tr>
        </table>

    </div>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
    $(function () {
        $('.dialog-message .actions a.remove').click(function () {
            if (confirm("Удалить диалог?")) {
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("/im/default/removeDialog") ?>',
                    data:{id:$(this).parents('.dialog-message').find('input.dialog_id').val()},
                    type:'POST',
                    dataType:'JSON',
                    success:function (response) {
                        if (response.status) {
                            $(this).parents('.dialog-message').remove();
                            if (response.active_dialog_url == '')
                                $('.nav .opened').hide();
                            else
                                $('.nav .opened a').attr("href", response.active_dialog_url);
                        }
                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('div.dialog-message').click(function () {
            var url = $(this).find('.dialog_url').val();
            window.location = url;
        });
    });

    comet.addEvent('<?php echo CometModel::TYPE_NEW_MESSAGE ?>', 'ShowNewMessage');

    function ShowNewMessage(result, id) {
        ShowNewMessagesCount(result.unread_count);
    }
</script>


