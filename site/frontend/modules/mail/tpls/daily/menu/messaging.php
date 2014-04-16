<?php
/**
 * @var MailMessageDaily $message
 */
?>

<?php if ($message->newMessagesCount > 0): ?>
    <td  height="10" style="">
        <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="10" width="30" border="0" />
    </td>
    <td align="center" valign="top">
        <!-- icon -->
        <a href="<?php echo $message->createUrl($message->getMessagesUrlParams(), 'menuIcon'); ?>" target="_blank">
            <table style="margin-bottom:5px;margin-left: 20px;" cellpadding="0" border="0" cellspacing="0" width="60" height="50" >
                <tr>
                    <td background="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ico-messages.png" bgcolor="#ffffff" width="60" height="50" valign="top" align="right">
                        <!--[if gte mso 9]>
                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:60px;height:50px;">
                            <v:fill type="tile" src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/ico-messages.png" color="#ffffff" />
                            <v:textbox inset="0,0,0,0">
                        <![endif]-->
                        <div>
                            <table style="margin: 2px 3px 0 5px;" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="right" style="color: #fff;">
                                        <span style="padding: 1px 5px;border-radius: 10px; border: 2px solid #ffffff;background:#f84219;color:#ffffff;font-size:12px;line-height:14px;vertical-align:top; display:inline-block;"><?php echo $message->newMessagesCount; ?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--[if gte mso 9]>
                        </v:textbox>
                        </v:rect>
                        <![endif]-->
                    </td>
                </tr>
            </table>
        </a>
        <table style="margin: 5px;" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td align="center">
                    <a href="<?php echo $message->createUrl($message->getMessagesUrlParams(), 'menuLink'); ?>" style="color: #4a89dc; text-decoration:underline;" target="_blank">Новые<br />сообщения</a>
                </td>
            </tr>
        </table>
    </td>
<?php endif; ?>