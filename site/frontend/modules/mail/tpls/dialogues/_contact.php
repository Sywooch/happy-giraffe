<?php
/**
 * @var MessagingContact $contact
 * @var MailMessageDialogues $message
 */
$city = $contact->user->address->city;
$country = $contact->user->address->country;
$urlParams = array('/messaging/default/index', 'interlocutorId' => $contact->user->id);
?>

<td  height="3" style="">
    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="3" width="30px" border="0" />
</td>
<td width="auto">
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:8px;">
        <tr>
            <td valign="top" align="center">
                <span style="margin: 0 auto;">
                    <a href="<?php echo $message->createUrl($urlParams, 'avatar'); ?>" style="width:72px; text-decoration:none;" target="_blank">
                        <img src="<?php echo $contact->user->getAvatarUrl(); ?>" style="-moz-border-radius:36px;-webkit-border-radius:36px;border-radius:36px;">
                    </a>
                    <?php if ($contact->unreadCount != $message->messagesCount): ?>
                        <span style="margin:3px 0 0 -18px; padding: 1px 5px;border-radius: 10px; border: 2px solid #ffffff;background:#f84219;color:#ffffff;font-size:11px;line-height:14px;vertical-align:top; display:inline-block;"><?php echo $contact->unreadCount; ?></span>
                    <?php endif; ?>
                </span>
            </td>
        </tr>
        <tr>
            <td valign="top" align="center">
                <a href="<?php echo $message->createUrl($urlParams, 'name'); ?>" style="color:#289fd7;font:12px arial, helvetica, sans-serif;text-decoration:none;" target="_blank"><?php echo $contact->user->getFullName(); ?></a>
                <?php if ($contact->user->birthday !== null): ?>
                    <span style="color:#9d9c9c; font-size:9px;"><?php echo $contact->user->getNormalizedAge(); ?></span>
                <?php endif; ?>
            </td>
        </tr>
        <?php if ($city !== null): ?>
            <tr>
                <td align="center">
                    <span style="color:#858484;font:9px/12px tahoma, helvetica, sans-serif;"><img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/flags/<?php echo $country->iso_code; ?>0018.gif" style="margin-right:5px;"><?php echo $city->name; ?></span>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</td>