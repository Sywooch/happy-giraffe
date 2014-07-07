<?php
/**
 * @var DefaultCommand $this
 * @var MailMessageDialogues $message
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $message->getSubject(); ?></title>

</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="background: #f0f0f0;">
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse: collapse;background: #f0f0f0;font-size: 12px; font-family: arial, sans-serif; color: #333333">
        <tr>
            <td height="20">
                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="20" width="100%" border="0" />
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="700px" style="background: #fff;">

                    <tr>
                        <td valign="top" height="5px" colspan="3" style="font-size:0; line-height:0;">
                            <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/mail-top-border.gif" width="100%" height="5px"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="1" width="100%" border="0" />
                        </td>
                        <td>
                            <!-- BEGIN TEMPLATE // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="660px" style="background: #fff;margin: 0 20px;">
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- BEGIN HEADER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                                            <tr>
                                                <td  height="17">
                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="17" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="center">
                                                    <a href="<?php echo $message->createUrl(array('site/index'), 'topLogo'); ?>" target="_blank">
                                                        <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/mail-top-logo.png" width="221px" height="62px"/>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  height="25" style="border-bottom: 1px solid #f1f4f7">
                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="25" width="100%" border="0" />
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // END HEADER -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- BEGIN BODY // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td  height="20" style="">
                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="20" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #333333; font-size: 16px;text-align:center;"><?php echo $message->getTitle(); ?></td>
                                            </tr>

                                            <tr>
                                                <td  height="30" style="">
                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="30" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>

                                                <td valign="top" align="center">
                                                    <!-- messages -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="<?php echo ($message->contactsCount > 1) ? '600' : '400'; ?>px">
                                                        <tr>
                                                            <td  height="3" style="">
                                                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="3" width="30px" border="0" />
                                                            </td>
                                                            <td align="center" valign="top" >
                                                                <a href="<?php echo $message->createUrl($message->getMainUrlParams(), 'readMessagesIcon'); ?>" style="text-decoration:none;border:0;" target="_blank">
                                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td background="http://109.87.248.203/new/images/mail/messages.png" bgcolor="#ffffff" width="125" height="108" valign="top" align="center">
                                                                                <!--[if gte mso 9]>
                                                                                <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:125px;height:108px;">
                                                                                    <v:fill type="tile" src="http://109.87.248.203/new/images/mail/messages.png" color="#ffffff" />
                                                                                    <v:textbox inset="0,0,0,0">
                                                                                <![endif]-->
                                                                                <div style="padding: 10px 5px 75px 82px;color: #ffffff;width:35px;background-repeat:no-repeat;font-size:21px; line-height: 25px;"><?php echo $message->messagesCount; ?></div>
                                                                                <!--[if gte mso 9]>
                                                                                </v:textbox>
                                                                                </v:rect>
                                                                                <![endif]-->
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </a>
                                                            </td>
                                                            <?php $message->render('dialogues/_contact', array('contact' => $message->contacts[0])); ?>
                                                            <?php if ($message->contactsCount > 1): ?>
                                                                <?php $message->render('dialogues/_contact', array('contact' => $message->contacts[1])); ?>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <?php if ($message->contactsCount > 2): ?>
                                                            <tr>
                                                                <td colspan="6" height="40px">
                                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="40" width="100%" border="0" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <?php $message->render('dialogues/_contact', array('contact' => $message->contacts[2])); ?>
                                                                <?php if ($message->contactsCount > 3): ?>
                                                                    <?php $message->render('dialogues/_contact', array('contact' => $message->contacts[3])); ?>
                                                                    <?php if ($message->contactsCount > 5): ?>
                                                                        <td  height="3" style="">
                                                                            <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="3" width="20px" border="0" />
                                                                        </td>
                                                                        <td width="auto" valign="top">
                                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:23px;">
                                                                                <tr>
                                                                                    <td align="center">
                                                                                        <span style="color:#cccccc;font:24px/26px tahoma, helvetica, sans-serif;">еще <?php echo ($message->contactsCount - 4); ?></span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    <?php elseif ($message->contactsCount == 5): ?>
                                                                        <?php $message->render('dialogues/_contact', array('contact' => $message->contacts[4])); ?>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <td  height="3" style="">
                                                                        <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="3" width="20px" border="0" />
                                                                    </td>
                                                                    <td width="auto" valign="top" align="center" colspan="3"  style="padding-top: 23px;">
                                                                        <a href="<?php echo $message->createUrl($message->getMainUrlParams(), 'readMessagesLink'); ?>" style="color:#3482e2; font-size:24px;" target="_blank">Прочитать сообщения</a>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  height="30" style="">
                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="30" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <?php if ($message->contactsCount != 3): ?>
                                                <tr>
                                                    <td align="center">
                                                        <a href="<?php echo $message->createUrl(array('/messaging/default/index', 'readMessagesLink')); ?>" style="color:#3482e2; font-size:24px;" target="_blank">Прочитать сообщение</a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                        <!-- // END BODY -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- BEGIN FOOTER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                                            <tr>
                                                <td  height="70" style="">
                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="70" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;padding-bottom:17px;">
                                                    С наилучшими пожеланиями,<br/>
                                                    <span style="color: #3587ec;"><a href="<?php echo $message->createUrl(array('site/index'), 'bottomLink'); ?>" style="color: #3587ec;" target="_blank">Веселый Жираф</a></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top:1px solid #e6e5e5;padding:6px 0;">

                                                    <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Это письмо было сгенерированно автоматически. Пожалуйста не отвечайте на него. Если вы хотите обратиться в службу поддержки сайта «Веселый Жираф», напишите нам по адресу <span style=" color: #3587ec;"><a href="mailto:support@happy-giraffe.ru" target="_blank" style="color: #3587ec;">support@happy-giraffe.ru</a></span><br/>
                                                    <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Вы получили это письмо, так как являетесь пользователем сайта "Веселый Жираф". <a href="{unsubscribe}" target="_blank" style="color: #3587ec;">Отписаться от рассылки</a></p>
                                                    <p style="font:10px tahoma, arial, sans-serif; color: #979696;">{accountcontactinfo}</p>
                                                    <br/>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td  height="10" style="">
                                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="10" width="100%" border="0" />
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // END FOOTER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // END TEMPLATE -->
                        </td>
                        <td width="20px">
                            <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="1" width="100%" border="0" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td  height="30">
                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="30" width="100%" border="0" />
            </td>
        </tr>
    </table>
</center>
</body>
</html>