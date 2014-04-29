<?php
/**
 * @var DefaultCommand $this
 * @var MailMessageNotificationDiscuss $message
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- script for develop livereload -->
        <script src="//localhost:35729/livereload.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Заголовок</title>

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
                        <table border="0" cellpadding="0" cellspacing="0" width="720px" style="background: #fff;">

                            <tr>
                                <td valign="top" height="5px" colspan="3" style="font-size:0; line-height:0;">
                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/new/images/mail/mail-top-border.gif" width="100%" height="5px"/>
                                </td>
                            </tr>
                            <tr>
                                <td width="30">
                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="1" width="30" border="0" />
                                </td>
                                <td>
                                    <!-  BEGIN TEMPLATE // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="660px" style="background: #fff;">
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-  BEGIN HEADER // -->
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
                                                <!-  // END HEADER -->
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td  height="25" style="">
                                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="25" width="100%" border="0" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #333333; font-size: 16px;"><?php echo $message->getTitle(); ?></td>
                                        </tr>

                                        <tr>
                                            <td  height="20" style="">
                                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="20" width="100%" border="0" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <!--  BEGIN BODY // -->

                                                <table cellpadding="0" cellspacing="0" border="0" width="530">
                                                    <?php $message->render('notification/' . $message->type); ?>
                                                    <?php foreach ($message->commentsToShow as $comment): ?>
                                                        <?php $message->render('notification/_comment', compact('comment')); ?>
                                                    <?php endforeach; ?>
                                                    <tr>
                                                        <td  height="20" style="">
                                                            <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="20" border="0" />
                                                        </td>
                                                    </tr>
                                                    <?php if ($message->totalCommentsCount > count($message->commentsToShow)): ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td align="right">
                                                                <a href="<?php echo $message->createUrl($message->model->getUrl(true, true), 'moreLink'); ?>" style="color: #3482e2; text-decoration:underline; font-size: 22px;">и еще <?php echo $message->getMoreCount(); ?> <?php echo Str::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), $message->getMoreCount()); ?></a>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    
                                                </table>


                                
                                                <!--  // END BODY -->
                                            </td>
                                        </tr>

                                        <tr>
                                            <td  height="50" style="">
                                                <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="50" width="100%" border="0" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-  BEGIN FOOTER // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                                                    <tr>
                                                        <td style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;padding-bottom:17px;">
                                                            С наилучшими пожеланиями,<br/>
                                                            <span style="color: #3587ec;"><a href="<?php echo $message->createUrl(array('site/index'), 'bottomLink'); ?>" target="_blank" style="color: #3587ec;">Веселый Жираф</a></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-top:1px solid #e6e5e5;padding:6px 0;">

                                                            <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Это письмо было сгенерированно автоматически. Пожалуйста не отвечайте на него. Если вы хотите обратиться в службу поддержки сайта «Веселый Жираф», напишите нам по адресу <span style=" color: #3587ec;"><a href="mailto:info@happy-giraffe.ru" target="_blank" style="color: #3587ec;">info@happy-giraffe.ru</a></span><br/>
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
                                                <!-  // END FOOTER -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-  // END TEMPLATE -->
                                </td>
                                <td width="30">
                                    <img src="<?php echo Yii::app()->request->hostInfo; ?>/images/mail/blank.gif" height="1" width="30" border="0" />
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