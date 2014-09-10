<?php
/**
 * @var $user User
 * @var $work ContestWork
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<table width="100%" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; line-height: 0;">
    <tbody>

    <tr><td height="20"><img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0"/></td></tr>

    <tr>
        <td>

            <table width="553" style="margin:0 auto;border-collapse: collapse; background: #ffffff;" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td height="116" align="center">

                                    <a href="http://www.happy-giraffe.ru?utm_source=email" target="_blank" style="text-decoration: none;"><img src="http://www.happy-giraffe.ru/images/mail/logo.png" width="194" height="116" border="0"/></a>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td width="12" height="27"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="27" border="0"/></td>
                                <td width="526" height="27" align="center">
                                    <img src="http://www.happy-giraffe.ru/images/mail/welcome_top.gif" width="526" height="27" border="0"/>
                                </td>
                                <td width="12" height="27"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="27" border="0"/></td>
                            </tr>
                            <tr>
                                <td width="12"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="100%" border="0"/></td>
                                <td width="526" align="center" style="background: #c8ebff;">
                                    <div style="font: normal 15px/1 arial, sans-serif; color: #232323; padding: 3px 5px;">
                                        Добрый день, <?=$user->first_name ?>! Фотоконкурс «Мой друг» в самом разгаре!
                                    </div>
                                </td>
                                <td width="12"><img width="12" height="100%" border="0" src="http://www.happy-giraffe.ru/images/mail/blank.gif"/></td>
                            </tr>
                            <tr style="line-height:9px;font-size:1px;">
                                <td width="12" height="10">
                                    <img width="12" height="10" border="0" src="http://www.happy-giraffe.ru/images/mail/blank.gif"/>
                                </td>
                                <td width="526" height="10" align="center">
                                    <img width="526" height="10" border="0" src="http://www.happy-giraffe.ru/images/mail/welcome_bottom.gif"/>
                                </td>
                                <td width="12" height="10">
                                    <img width="12" height="10" border="0" src="http://www.happy-giraffe.ru/images/mail/blank.gif"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="27"><img width="100%" height="10" border="0" src="http://www.happy-giraffe.ru/images/mail/blank.gif"/></td>
                </tr>
            </tbody>
            </table>
            <table width="340" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto;border-collapse: collapse;border:1px solid #eeeded">
                <tbody>
                <tr>
                    <td align="center" style="padding:20px">
                        <img border="0" src="http://www.happy-giraffe.ru/images/contest/widget-10.jpg" style="text-align:center;"/>

                        <div style="border:1px solid #E5E4E4;display: block;margin: 10px auto 5px;padding:2px;width:210px;" class="img">
                            <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/?utm_source=email"><img border="0" src="<?=$work->photoAttach->photo->getPreviewUrl(210, null, Image::WIDTH) ?>"/></a>

                            <div style="font: bold 11px/13px Arial,Tahoma,Verdana,sans-serif;padding: 6px 10px;text-align: left;">
                                <?=$work->title ?>
                            </div>
                        </div>
                        <table width="210" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto;border-collapse: collapse;">
                            <tbody>
                            <tr>
                                <td align="left" style="color: #727272;font: 15px/30px arial, helvetica, sans-serif;">
                                    <span style="color: #696767;font-size: 25px;"><?=$work->position ?></span> место
                                </td>
                                <td align="right">
                                    <div style="color:#FD5807;font: italic 30px/25px 'Times New Roman',Georgia,Times,serif;">
                                        <?=$work->rate ?>
                                    </div>
                                    <div style="color:#737373;font: 10px/10px arial, helvetica, sans-serif;">баллов</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="620" cellspacing="0" cellpadding="0" align="center"
                   style="margin:0 auto;border-collapse: collapse; background: #ffffff;">
                <tbody>
                <tr>
                    <td style="padding:27px 0 12px;"><b>
                        <font size="2" face="Arial, Helvetica, sans-serif" color="#232323" style="font-size: 13px;">Ваша конкурсная работа может занять призовое место!</font></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin:0 0 10px;font:13px arial, helvetica, sans-serif;color:#232323;line-height:19px;">
                            Прошла уже неделя конкурса «Мой друг», он близится к завершению. Чтобы увеличить шансы на
                            победу и стать обладателем одной из игрушек-комфортеров "Cuski" сделайте три простых
                            шага:</p>
                        <ul style="list-style:none;font:13px arial, helvetica, sans-serif;color:#232323;line-height:19px;margin:0 0 10px;padding:0;">
                            <li>1. Попросите всех друзей и знакомых проголосовать за вас, отправив им ссылку на свою
                                конкурсную работу;
                            </li>
                            <li>2. Сделайте ссылку на фотографию подписью в аське и скайпе;</li>
                            <li>3. Замените ссылкой на конкурсную работу свои статусы в социальных сетях.</li>
                        </ul>
                        <p style="margin:0 0 10px;font:13px arial, helvetica, sans-serif;color:#232323;line-height:19px;">
                            Желаем вам победы!</p></td>
                </tr>
                <tr>
                    <td  height="60" style="">
                        <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="60" width="100%" border="0" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;">
                            С наилучшими пожеланиями,<br/>
                            <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru/" target="_blank" style="color: #3587ec;">Веселый Жираф</a></span>
                        </div>
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
                            Вы получили это письмо, так как являетесь пользователем сайта "Веселый Жираф". <span style=" color: #3587ec;"><a href="<?php echo $message->createUrl(array('/profile/settings/subscribes')); ?>" target="_blank" style="color: #3587ec;">Отписаться от рассылки</a></span>
                        </p>

                    </td>
                </tr>

                <tr>
                    <td  height="10" style="">
                        <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="10" width="100%" border="0" />
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td height="20"><img width="100%" height="20" border="0" src="http://www.happy-giraffe.ru/images/mail/blank.gif"/></td>
    </tr>
    </tbody>
</table>