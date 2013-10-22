<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Заголовок</title>
<table width="100%" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; line-height: 0;">
    <tbody>

    <tr><td height="20"><img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0" /></td></tr>

    <tr>
        <td>

            <table width="720" style="margin:0 auto;border-collapse: collapse; background: #ffffff;" align="center" cellpadding="0" cellspacing="0">

                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td height="116" align="center">

                                    <a href="http://www.happy-giraffe.ru/?utm_source=email&utm_campaign=pets1" target="_blank" style="text-decoration: none;"><img src="http://www.happy-giraffe.ru/images/mail/logo.png" width="194" height="116" border="0" /></a>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td  height="27"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="27" border="0" /></td>
                                <td width="680" height="27" align="center">
                                    <img src="http://www.happy-giraffe.ru/images/mail/welcome_top.gif" width="680" height="27" border="0" />
                                </td>
                                <td  height="27"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="27" border="0" /></td>
                            </tr>
                            <tr>
                                <td ><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="100%" border="0" /></td>
                                <td width="680" align="center" style="background: #c8ebff;">

                                    <div style="font: normal 15px/1 arial, sans-serif; color: #232323; padding: 3px 5px;">Добрый день, {firstname}! Конкурс &laquo;Наш домашний любимец&raquo; в самом разгаре!</div>

                                </td>
                                <td ><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="100%" border="0" /></td>
                            </tr>
                            <tr>
                                <td ><img width="12" height="10" src="http://www.happy-giraffe.ru/images/mail/blank.gif" border="0" /></td>
                                <td width="680" height="10" align="center">
                                    <img src="http://www.happy-giraffe.ru/images/mail/welcome_bottom.gif" width="680" height="10" border="0" />
                                </td>
                                <td ><img width="12" height="10" src="http://www.happy-giraffe.ru/images/mail/blank.gif" border="0" /></td>
                            </tr>

                        </table>
                    </td>
                </tr>

                <tr>
                    <td height="27">
                        <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="10" border="0" />
                    </td>
                </tr>

            </table>

            <table width="680" style="margin:0 auto;border-collapse: collapse; background: #ffffff;line-height:auto;" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <a href="<?=$work->url?>?utm_source=email&utm_campaign=pets1" style="color:#186fb8;">
                            <font face="Arial, Helvetica,sans-serif" size="2" color="#186fb8" style="font-size: 30px;line-height:35px; font-weight:bold;"><?=$work->content->title?></font>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td height="15">
                        <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="15" border="0" />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <a href="<?=$work->url?>?utm_source=email&utm_campaign=pets1" style=" position:relative;text-decoration:none;">
                            <!--  -->
                            <img src="/images/mail/contest/pets1/img1.jpg" alt="" width="471" height="354" border="0">
                            <?=CHtml::image($photo->getPreviewUrl(471, null, Image::WIDTH), array('border' => 0, 'width' => '471', 'height' => 471 / $photo->width * $photo->height ))?>
                            <div style="margin: 15px 10px 0 12px; position:absolute; bottom:12px; left: 0;">
                                <!--  -->
                                <img src="/images/mail/contest/pets1/logo.png" alt="" width="86" height="86" border="0">
                            </div>
                            <?php if ($work->rate > 0): ?>
                                <div  style="margin: 25px 10px 0 12px; position:absolute; bottom:24px; right: 20px;width:120px;background:#fb0202; text-align:center;padding:7px 0;">
                                    <div style="margin:"><font face="Roboto, Helvetica, Arial, sans-serif" size="2" color="#ffffff" style="font-size: 35px;line-height:32px;"><?=$work->rate?></font></div>
                                    <div style="color: #ffffff; font-size:13px; line-height:13px;font-family:Arial, Helvetica,sans-serif;">баллов</div>
                                </div>
                            <?php endif; ?>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td height="35">
                        <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="35" border="0" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="470" style="margin:0 auto;border-collapse: collapse; background: #ffffff;line-height:auto;" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td  align="left" style="">
                                    <font face="Arial, Helvetica, sans-serif" size="3" color="#2a2a2a" style="font-size: 15px;line-height:21px; font-weight:bold;">Ваша конкурсная работа может занять призовое место!</font>
                                </td>
                            </tr>

                            <tr>
                                <td height="10">
                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="10" border="0" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin:7px 0;"><font face="Arial, Helvetica, sans-serif" size="2" color="#1f1f1f" style="font-size: 13px;line-height:18px;">Чтобы увеличить шансы на победу и стать обладателем одного из призов сделайте  три простых шага:</font></p>
                                    <p style="margin:4px 0;"><font face="Arial, Helvetica, sans-serif" size="2" color="#1f1f1f" style="font-size: 13px;line-height:18px;">1. Попросите всех друзей и знакомых проголосовать за вас, отправив им ссылку  на свою конкурсную работу;</font></p>
                                    <p style="margin:4px 0;"><font face="Arial, Helvetica, sans-serif" size="2" color="#1f1f1f" style="font-size: 13px;line-height:18px;">2. Сделайте ссылку на работу подписью в аське и скайпе;</font></p>
                                    <p style="margin:4px 0;"><font face="Arial, Helvetica, sans-serif" size="2" color="#1f1f1f" style="font-size: 13px;line-height:18px;">3. Замените ссылкой на работу свои статусы в социальных сетях.</font></p>

                                </td>
                            </tr>

                            <tr>
                                <td height="10">
                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="10" border="0" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font face="Arial, Helvetica, sans-serif" size="2" color="#1f1f1f" style="font-size: 14px;line-height:28px;">Ссылка для голосования за вашего питомца</font>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="<?=$work->url?>?utm_source=email&utm_campaign=pets1" style="color:#4a98d3; "><font face="Arial, Helvetica, sans-serif" size="2" color="#4a98d3" style="font-size: 16px;line-height:18px;"><?=$work->url?></font></a>
                                </td>
                            </tr>

                            <tr>
                                <td height="30">
                                    <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="30" border="0" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin:4px 0;"><font face="Arial, Helvetica, sans-serif" size="2" color="#1f1f1f" style="font-size: 13px;line-height:18px;">Желаем победы!</font></p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="50">
                        <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="50" border="0" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;margin-bottom:20px;">
                            С наилучшими пожеланиями,<br/>
                            <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru/?utm_source=email&utm_campaign=pets1" target="_blank" style="color: #3587ec;">Веселый Жираф</a></span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="border-top:1px solid #e6e5e5;padding:6px 0;">

                        <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Это письмо было сгенерированно автоматически. Пожалуйста не отвечайте на него. Если вы хотите обратиться в службу поддержки сайта «Веселый Жираф», напишите нам по адресу <span style=" color: #3587ec;"><a href="mailto:support@happy-giraffe.ru" target="_blank" style="color: #3587ec;">support@happy-giraffe.ru</a></span><br/>
                            <br/>
                            Вы получили это письмо, так как являетесь пользователем сайта "Веселый Жираф". <span style=" color: #3587ec;"><a href="{unsubscribe}" target="_blank" style="color: #3587ec;">Отписаться от рассылки</a></span>
                        </p>
                        <p style="font:10px tahoma, arial, sans-serif; color: #979696;">{accountcontactinfo}</p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <tr><td height="20"><img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0" /></td></tr>

    </tbody>
</table>