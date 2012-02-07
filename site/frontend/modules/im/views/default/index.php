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
        ?>">
        <input type="hidden" value="<?php echo $this->createUrl('/im/default/dialog', array('id' => $dialog->id)) ?>"
               class="dialog_url">
        <table>
            <tr>
                <td class="user">

                    <div class="ava"></div>
                    <span><?php echo Im::model()->GetDialogUser($dialog->id)->getFullName() ?></span>

                </td>
                <td class="message-icon">
                    <div class="icon"></div>
                </td>
                <td class="content">
                    <?php echo CHtml::decode($dialog->lastMessage->text) ?>
                </td>
                <td class="meta">
                    <span><?php
                        if (date("Y:m:d", strtotime($dialog->lastMessage->created)) == date("Y:m:d"))
                            echo 'Сегодня';
                        elseif (date("Y", strtotime($dialog->lastMessage->created)) == date("Y"))
                            echo date("j", strtotime($dialog->lastMessage->created)) . ' '
                                . HDate::ruMonthShort(date("m", strtotime($dialog->lastMessage->created)));
                        else
                            echo date("Y", strtotime($dialog->lastMessage->created)) . '<br>' .
                                date("j", strtotime($dialog->lastMessage->created)) . ' '
                                . HDate::ruMonthShort(date("m", strtotime($dialog->lastMessage->created)))
                        ?><br/><?php echo date("H:i", strtotime($dialog->lastMessage->created))  ?></span>
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
        $('div.dialog-message').click(function () {
            var url = $(this).find('.dialog_url').val();
            window.location = url;
        });
    });
</script>


