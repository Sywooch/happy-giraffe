<?php
/**
 * @var MailMessageNotificationDiscuss $message
 */
?>

<tr>
    <td valign="top" style="padding-top: 5px;padding-right: 2px;">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ansver-question.png" style="display:block;">
    </td>
    <td valign="top"></td>
    <td valign="top" style="padding-top: 12px;">
        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td style="font-size: 16px; color: #111111;">
                    У вас <?php echo $message->totalCommentsCount; ?> <?php echo Str::GenerateNoun(array('новый ответ', 'новых ответа', 'новых ответов'), $message->totalCommentsCount); ?> <br />
                    на ваш вопрос <a href="<?php echo $message->createUrl($message->model->getUrl(true, true)); ?>"  style="color:#3482e2;text-decoration:underline;"><?php echo $message->model->title; ?></a>
                </td>
            </tr>
        </table>
    </td>
</tr>