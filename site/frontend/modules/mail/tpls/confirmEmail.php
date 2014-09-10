<?php
/**
 * @var MailMessageEmailConfirm $message
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Заголовок</title>

</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="background: #f0f0f0;">
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse: collapse;background: #f0f0f0;font-size: 12px; font-family: arial, sans-serif; color: #333333">
        <tr>
            <td height="20">
                <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0" />
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="700px" style="background: #fff;">

                    <tr>
                        <td valign="top" height="5px" colspan="3" style="font-size:0; line-height:0;">
                            <img src="http://www.happy-giraffe.ru/new/images/mail/mail-top-border.gif" width="100%" height="5px"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="20px">
                            <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="1" width="100%" border="0" />
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
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="17" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="center">
                                                    <a href="<?php echo $message->getActivationUrl(); ?>" target="_blank">
                                                        <img src="http://www.happy-giraffe.ru/new/images/mail/mail-top-logo.png" width="221px" height="62px"/>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  height="25" style="border-bottom: 1px solid #f1f4f7">
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="25" width="100%" border="0" />
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
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #666666; font-size: 16px;"><?php echo $message->getTitle(); ?></td>
                                            </tr>

                                            <tr>
                                                <td  height="10" style="">
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="10" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #333333; font-size: 18px;">Ура, теперь вы с нами!</td>
                                            </tr>
                                            <tr>
                                                <td  height="10" style="">
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="10" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo $message->getActivationUrl(); ?>" style="color: #0e72ed;font-size: 22px; " target="_blank">Зайти на сайт</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  height="25" style="">
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="25" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="border: 1px solid #e0d8f5; background: #eae4f9; padding: 15px 20px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                                                        <tr>
                                                            <td style="color: #464646; font-size: 13px; font-weight: bold;">
                                                                Ваши регистрационные данные:
                                                                <br />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td  height="5" style="">
                                                                <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="5" width="100%" border="0" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>E-mail:  <?php echo $message->user->email; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Пароль: <?php echo $message->password; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td  height="10" style="">
                                                                <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="10" width="100%" border="0" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color: #999">
                                                                Сохраните свои учетные данные. Вы можете <a href="<?php echo $message->getChangePasswordUrl(); ?>" style="color: #0e72ed;" target="_blank">изменить пароль</a> в Настройках своего профиля.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // END BODY -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- BEGIN FOOTER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                                            <tr>
                                                <td  height="60" style="">
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="60" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;">
                                                    С наилучшими пожеланиями,<br/>
                                                    <span style="color: #3587ec;"><a href="<?php echo $message->getActivationUrl(); ?>" target="_blank" style="color: #3587ec;">Веселый Жираф</a></span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td  height="40" style="">
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="40" width="100%" border="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top:1px solid #e6e5e5;padding:6px 0;">

                                                    <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Это письмо было сгенерированно автоматически. Пожалуйста не отвечайте на него. Если вы хотите обратиться в службу поддержки сайта «Веселый Жираф», напишите нам по адресу <span style=" color: #3587ec;"><a href="mailto:support@happy-giraffe.ru" target="_blank" style="color: #3587ec;">support@happy-giraffe.ru</a></span><br/>
                                                        <br/>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td  height="10" style="">
                                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="10" width="100%" border="0" />
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // END FOOTER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // END TEMPLATE -->
                        </td>
                        <td width="20">
                            <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="1" width="100%" border="0" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td  height="20">
                <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0" />
            </td>
        </tr>
    </table>
</center>
</body>
</html>