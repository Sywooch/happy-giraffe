<?php
/**
 * @var MailMessageNotificationDiscuss $message
 */
?>

<tr>
    <td valign="top" style="padding-top: 5px;padding-right: 2px;">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/comment.png" style="display:block;">
    </td>
    <td valign="top"></td>
    <td valign="top" style="padding: 12px 0 10px;">
        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td style="font-size: 16px;color: #111111">
                    У вас <?php echo $message->totalCommentsCount; ?> <?php echo Str::GenerateNoun(array('новый комментарий', 'новых комментария', 'новых комментария'), $message->totalCommentsCount); ?>  <br />
                    к  вашей записи <a href="<?php echo $message->createUrl($message->model->getUrl(true, true)); ?>"  style="color:#3482e2;text-decoration:underline;"><?php echo $message->model->title; ?></a>
                </td>
            </tr>
        </table>
    </td>
</tr>