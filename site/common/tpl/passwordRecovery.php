<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Заголовок</title>
<table width="100%" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; line-height: 0;">
    <tbody>

    <tr>
        <td>

            <table width="800" style="margin:0 auto;" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; background: #ffffff;">

                <tr>
                    <td style="padding:20px 0;">

                        <div style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;">

                            <div style="margin-bottom:20px;">
                                <span style="font-size:15px;">Добрый день, <?=$user->getFullName() ?>!</span><br/>
                                <br/>
                                Наша система получила уведомление о том, что вы забыли свой пароль на сайте «Весёлый Жираф».
                            </div>

                            <table style="margin-bottom:20px;background:#fefcd4;">
                                <tr>
                                    <td style="padding:5px 5px 0px 15px;">
                                        <span style="color:#5b5b5b;font-size:20px;">Ваш e-mail:</span>
                                    </td>
                                    <td style="padding:5px 15px 0px 5px;">
                                        <span style="color:#3587ec;font-size:20px;"><a href="mailto:<?=$user->email ?>" target="_blank" style="color:#3587ec;font-size:20px;"><?=$user->email ?></a></a></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0px 5px 5px 15px;">
                                        <span style="color:#5b5b5b;font-size:20px;">Ваш пароль:</span>
                                    </td>
                                    <td style="padding:0px 15px 5px 5px;">
                                        <span style="color:#5b5b5b;font-size:20px;"><?=$password ?></span>
                                    </td>
                                </tr>

                            </table>

                            <div style="margin-bottom:40px;">
                                Вы всегда можете поменять свой пароль в разделе "Мои настройки"<br/>по адресу:
                                <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru/profile" target="_blank" style="color: #3587ec;">http://www.happy-giraffe.ru/profile</a></span>
                            </div>

                            <div style="margin-bottom:20px;">
                                С наилучшими пожеланиями,<br/>
                                <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru" target="_blank" style="color: #3587ec;">Веселый Жираф</a></span>
                            </div>

                        </div>

                    </td>
                </tr>

                <tr>
                    <td style="border-top:1px solid #e6e5e5;padding:6px 0;">

                        <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Это письмо было сгенерированно автоматически. Пожалуйста не отвечайте на него. Если вы хотите обратиться в службу поддержки сайта «Веселый Жираф», <br/>напишите нам по адресу <span style=" color: #3587ec;"><a href="mailto:support@happy-giraffe.ru" target="_blank" style="color: #3587ec;">support@happy-giraffe.ru</a></span></p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>

    <tr><td height="20"><img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0" /></td></tr>

    </tbody>
</table>