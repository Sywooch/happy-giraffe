<?php
/**
 * @var MailMessageNotificationDiscuss $message
 * @var MailComment $comment
 */
?>

<tr>
    <td  height="10" style="">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="10" border="0" />
    </td>
</tr>
<tr>
    <td valign="top" style="padding-top: 5px;padding-right: 2px;">
        <img src="<?php echo $message->user->getAvatarUrl(); ?>" style="display:block;border-radius:36px;">
    </td>
    <td valign="top">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/arrow-answer-blue.gif" alt="" width="10" height="45" />
    </td>
    <td valign="top" bgcolor="#edfaff" style="background: #edfaff; padding: 12px 20px 15px 15px;border-radius: 5px;">
        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td>
                    <a href="<?php echo $message->createUrl($comment->author->getUrl(true), 'commentAuthorLink'); ?>" style="color:#289fd7;text-decoration:none;"><?php echo $comment->author->getFullName(); ?></a>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 7px;padding-bottom: 10px;">
                    <?php echo $comment->getCommentText(MailMessageNotification::COMMENT_LENGTH); ?>
                    <?php if ($comment->exceedsLength(MailMessageNotification::COMMENT_LENGTH)): ?>
                        <a href="<?php echo $message->createUrl($comment->getUrl(true), 'readMore'); ?>" style="color:#289fd7;text-decoration:underline;font-size: 11px;font-family:tahoma, verdana, arial;">Читать далее</a>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="<?php echo $message->createUrl($comment->getUrl(true), 'readMore'); ?>" style="color: #fefefe; background: #50b145; padding: 1px 4px;text-decoration:none;">Ответить</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td  height="10" style="">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="10" border="0" />
    </td>
</tr>