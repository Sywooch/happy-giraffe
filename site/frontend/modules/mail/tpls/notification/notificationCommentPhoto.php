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
    <td valign="top" style="padding: 12px 0 15px;">
        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td style="font-size: 16px; color: #111111;">
                    У вас <?php echo Str::GenerateNoun(array('новый комментарий', 'новых комментария', 'новых комментария'), $message->totalCommentsCount); ?>  <br />
                    к  вашей записи <a href="<?php echo $message->createUrl($message->model->getUrl(true, true)); ?>"  style="color:#3482e2;text-decoration:underline;"><?php echo $message->model->title; ?></a>
                </td>
            </tr>
            <tr>
                <td style="padding-top:10px;">
                    <!-- Width 200px, height auto -->
                    <img src="<?php echo $message->model->getPreviewUrl(200, null, Image::WIDTH); ?>" alt="" />
                </td>
            </tr>
        </table>
    </td>
</tr>