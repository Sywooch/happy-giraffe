<?php
/**
 * @var DefaultCommand $this
 * @var MailMessageDialogues $message
 */
?>

<tr>
    <td align="center" valign="top">
        <!-- BEGIN FOOTER // -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" >
            <tr>
                <td  height="60" style="">
                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="60" width="100%" border="0" />
                </td>
            </tr>
            <tr>
                <td style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;">
                    С наилучшими пожеланиями,<br/>
                    <span style="color: #3587ec;"><a href="<?php echo $message->createUrl(array('site/index'), 'bottomLink'); ?>" style="color: #3587ec;" target="_blank">Веселый Жираф</a></span>
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
                    <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Вы получили это письмо, так как являетесь пользователем сайта "Веселый Жираф". <a href="<?php echo $message->createUrl(array('/profile/settings/subscribes')); ?>" target="_blank" style="color: #3587ec;">Отписаться от рассылки</a></p>
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