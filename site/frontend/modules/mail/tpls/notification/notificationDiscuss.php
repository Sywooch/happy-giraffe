<?php
/**
 * @var MailMessageNotificationDiscuss $message
 */
?>

<tr>
    <td valign="top" style="padding-top: 10px;padding-right: 2px;">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/discus.png" style="display:block;">
    </td>
    <td valign="top"></td>
    <td valign="top" style="padding-top: 12px;">
        <table style="" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td style="font-size: 16px; color: #111111;">
                    Продолжается обсуждение <br />
                    <a href="<?php echo $message->createUrl($message->model->getUrl(true, true), 'titleLink'); ?>"  style="color:#3482e2;text-decoration:underline;"><?php echo $message->model->title; ?></a>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px;padding-bottom: 10px;">
                    <table style="" cellpadding="0" cellspacing="0" border="0" >
                        <tr>
                            <td  style="padding-right: 10px;">

                                <img src="<?php echo $message->model->author->getAvatarUrl(24); ?>" alt="" style="display:block;border-radius:12px;">
                            </td>
                            <td >
                                <a href="<?php echo $message->createUrl($message->model->author->getUrl(true)); ?>" style="color:#289fd7;font:12px arial, helvetica, sans-serif;text-decoration:none;"><?php echo $message->model->author->getFullName(); ?></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>