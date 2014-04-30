<?php
/**
 * @var MailMessageNotificationReply $message
 */
?>

<tr>
    <td valign="top" style="padding-top: 10px;padding-right: 2px;">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ansver-comment.png" style="display:block;">
    </td>
    <td valign="top"></td>
    <td valign="top" style="padding-top: 12px;">
        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td style="font-size: 16px; color: #111111;">
                    У вас <?php echo $message->totalCommentsCount; ?> <?php echo Str::GenerateNoun(array('новый ответ', 'новых ответа', 'новых ответов'), $message->totalCommentsCount); ?> <br />
                    на ваш комментарий к записи <br />
                    <a href="<?php echo $message->createUrl($message->model->getUrl(true, true)); ?>"  style="color:#3482e2;text-decoration:underline;"><?php echo $message->model->title; ?></a>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px;padding-bottom: 10px;">
                    <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td valign="top" style="padding-top: 10px;padding-right: 1px;">
                                <img src="<?php echo $message->comment->author->getAvatarUrl(40);?>" alt="" style="display:block;border-radius:20px;">
                            </td>
                            <td valign="top">
                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/arrow-answer-yellow.gif" alt="" width="10" height="43" />
                            </td>
                            <td valign="top" bgcolor="#fffde1" style="background: #fffde1; padding: 12px 15px 15px 15px;border-radius: 5px;">
                                <table style="" cellpadding="0" cellspacing="0" border="0" width="365px">
                                    <tr>
                                        <td style="">
                                            <?php echo $message->comment->getCommentText(MailMessageNotification::COMMENTS_LENGTH); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>