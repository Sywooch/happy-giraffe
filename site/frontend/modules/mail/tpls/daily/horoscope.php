<?php
/**
 * @var MailMessageDaily $message
 */
?>

<table cellpadding="0" border="0" cellspacing="0" width="100%" style="margin-bottom:5px; border: 2px solid #5ab3f8;" bgcolor="#73c1fd">
    <tr>
        <td style="padding: 10px 10px 5px 18px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:10px;">
                <tr>
                    <td valign="top" style="padding-top: 5px;">
                        <a href="<?php echo $message->createUrl($message->horoscope->getUrl(true), 'link'); ?>" style="font-weight:bold;font-size:25px;line-height:28px;color:#ffffff;text-decoration:underline;" target="_blank">Ваш гороскоп<br />на сегодня</a>
                    </td>
                    <td background="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/horoscope-date.gif" bgcolor="#fdf6a3" width="58" height="64" valign="top" >
                        <!--[if gte mso 9]>
                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:58px;height:64px;">
                            <v:fill type="tile" src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/horoscope-date.gif" color="#fdf6a3" />
                            <v:textbox inset="0,0,0,0">
                        <![endif]-->
                        <div>
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td height="12" width="20">
                                        <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" width="20" height="12" border="0" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="color: #47a4ed;font-size:26px;line-height:26px;font-weight: bold;">
                                        <?php echo date("j", strtotime($message->horoscope->date)); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="color: #47a4ed;font-size:16px;line-height: 16px;font-weight: bold;padding-bottom: 8px;">
                                        <?php echo HDate::ruMonthShort(date("n", strtotime($message->horoscope->date))); ?>
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
        </td>
    </tr>
    <tr>
        <td style="padding: 0 10px 5px 18px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                <tr>
                    <td style="margin-bottom:5px;">
                        <!-- img horoscope -->
                        <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/widget/horoscope/big/<?php echo $message->horoscope->zodiac; ?>.png" alt="" width="140"/>
                    </td>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                            <tr>
                                <td align="center" style="color: #ffffff; font-size:30px; font-style:italic; font-family: 'times new roman', times, serif;">
                                    <?php echo $message->horoscope->zodiacText(); ?>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="color: #525151; font-size:12px;">
                                    <?php echo $message->horoscope->zodiacDates(); ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 25px 15px 30px; color: #ffffff; line-height: 18px;">
            <?php echo Str::truncate($message->horoscope->text, 256); ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 15px 10px 15px;">
            <table border="0" cellpadding="0" cellspacing="0" style="background-color:#ffe11b; border-radius:5px; margin:0 auto;">
                <tr>
                    <td align="center" valign="middle" style="color:#494848; font-size:14px;  line-height:150%; padding-top:10px; padding-right:18px; padding-bottom:10px; padding-left:18px;">
                        <a href="<?php echo $message->createUrl($message->horoscope->getUrl(true), 'button'); ?>" style="color:#494848; text-decoration:none;" target="_blank">Читать полностью</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding: 10px 15px 35px">
            <a href="<?php echo $message->createUrl($message->tomorrowHoroscope->getUrl(true)); ?>" style="color: #ffffff; text-decoration: underline;" target="_blank">На завтра</a>
        </td>
    </tr>
</table>