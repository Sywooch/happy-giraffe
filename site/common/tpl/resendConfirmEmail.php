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
                                Вы успешно зарегистрировались на сайте «Весёлый Жираф».<br/>
                                Ваш e-mail: <span style=" color: #3587ec;"><a href="mailto:<?=$user->email ?>" target="_blank" style="color: #3587ec;"><?=$user->email ?></a></span><br/>
                            </div>

                            <div style="margin-bottom:25px;line-height:22px;"><span style="font-size:22px;color: #3587ec;"><a href="http://www.happy-giraffe.ru/site/confirmEmail/?user_id=<?=$user->id ?>&code=<?=$code ?>" target="_blank" style="font-size:22px;color: #3587ec;">Нажмите сюда, чтобы подтвердить свой e-mail</a></span></div>

                            <div style="margin-bottom:40px;">
                                Если ссылка не работает, скопируйте и вставьте URL в адресную строку своего браузера:<br/>
                                <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru/site/confirmEmail/?user_id=<?=$user->id ?>&code=<?=$code ?>" target="_blank" style="color: #3587ec;">http://www.happy-giraffe.ru/site/confirmEmail/?user_id=<?=$user->id ?>&code=<?=$code ?></a></span>
                            </div>

                            <div style="margin-bottom:40px;">
                                С наилучшими пожеланиями,<br/>
                                <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru" target="_blank" style="color: #3587ec;">Веселый Жираф</a></span>
                            </div>

                            <div style="background:#eeedee;width:460px;padding:6px 10px;">Если произошла ошибка и вы не регистрировались на <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru" target="_blank" style="color: #3587ec;">www.happy-giraffe.ru</a></span>,<br/>просто не реагируйте на это письмо.</div>

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