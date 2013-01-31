<?php
/* @var $user User
 * @var $unread int
 * @var $dialogUsers DialogUser[]
 */
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<table width="100%" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; line-height: 0;">
    <tbody>

    <tr><td height="20"><img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0"/></td></tr>

    <tr>
        <td>

            <table width="553" style="margin:0 auto;border-collapse: collapse; background: #ffffff;" align="center" cellpadding="0" cellspacing="0">

                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td height="116" align="center">

                                    <!-- лого -->
                                    <a href="http://www.happy-giraffe.ru" target="_blank" style="text-decoration: none;"><img src="http://www.happy-giraffe.ru/images/mail/logo.png" width="194" height="116" border="0"/></a>

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
                                    <img src="http://www.happy-giraffe.ru/images/mail/welcome_top.gif" width="553" height="27" border="0"/>
                                </td>
                                <td width="12" height="27"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="27" border="0"/></td>
                            </tr>
                            <tr>
                                <td width="12"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="100%" border="0"/></td>
                                <td width="553" align="center" style="background: #c8ebff;">

                                    <!-- приветствие -->
                                    <div style="font: normal 15px/1 arial, sans-serif; color: #232323; padding: 3px 5px;">Добрый день, <?=$user->getFullName() ?>! Узнайте что вам написали прямо сейчас!</div>

                                </td>
                                <td width="12"><img width="12" src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="100%" border="0"/></td>
                            </tr>
                            <tr>
                                <td width="12"><img width="12" height="10" src="http://www.happy-giraffe.ru/images/mail/blank.gif" border="0"/></td>
                                <td width="553" height="10" align="center">
                                    <img src="http://www.happy-giraffe.ru/images/mail/welcome_bottom.gif" width="553" height="10" border="0"/>
                                </td>
                                <td width="12"><img width="12" height="10" src="http://www.happy-giraffe.ru/images/mail/blank.gif" border="0"/></td>
                            </tr>

                        </table>
                    </td>
                </tr>

                <tr>
                    <td height="10">
                        <img src="http://www.happy-giraffe.ru/images/mail/blank.gif" width="100%" height="10" border="0"/>
                    </td>
                </tr>

            </table>

            <table width="553" style="margin:0 auto;border-collapse: collapse; background: #ffffff;" align="center" cellpadding="0" cellspacing="0">

                <tr>
                    <td>
                        <div
                            style="margin:30px 0;text-align:center;font:25px arial, helvetica, sans-serif;color:#2a2a2a;">
                            У вас <?= $unread ?> <?= HDate::GenerateNoun(array('новое сообщение', 'новых сообщения', 'новых сообщений'), $unread) ?>!
                        </div>

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>

                                <?php $unreadShown = 0; ?>
                                <?php for($i=0;$i<count($dialogUsers) && $i < 4;$i++): ?>
                                <?php $dialogUser = $dialogUsers[$i] ?>
                                    <td width="50%" valign="top" style="padding-bottom:30px">

                                        <table width="250">
                                            <tr>
                                                <td width="90" valign="top">
                                                    <img src="<?= $dialogUser->user->getAvaOrDefaultImage() ?>" style="display:block;-moz-border-radius:36px;-webkit-border-radius:36px;border-radius:36px;"/>
                                                </td>
                                                <td valign="top">
                                                    <span style="color:#38a5f4;font:12px/16px arial, helvetica, sans-serif;"><?= $dialogUser->user->getFullName() ?></span><br/>
                                                    <?php if (!empty($dialogUser->user->address->country_id)):?>
                                                        <span style="color:#858484;font:9px/18px tahoma, helvetica, sans-serif;"><img src="http://www.happy-giraffe.ru/images/mail/flags/<?=  $dialogUser->user->address->country->iso_code; ?>0018.gif" style="margin-right:5px;"><?= CHtml::encode($dialogUser->user->address->getCityName()); ?></span><br/>
                                                    <?php endif ?>
                                                    <?php if (false):?>
                                                        <span style="color:#2aa908;font:11px/18px tahoma, helvetica, sans-serif;"></span><br/>
                                                    <?php endif ?>
                                                    <span style="color:#0d81d5;font:18px/20px arial, helvetica, sans-serif;">
                                                        <a href="<?= 'http://www.happy-giraffe.ru/user/'.$user->id .'/?im_interlocutor_id='.$dialogUser->user_id.'&token='.$token->content ?>&utm_source=email" target="_blank" style="color:#0d81d5;font:18px/20px arial, helvetica, sans-serif;">
                                                            <?php $current_unread = Dialog::getUnreadMessagesCount($dialogUser->dialog_id, $user->id); echo $current_unread ?>
                                                            <?= HDate::GenerateNoun(array('сообщение', 'сообщения', 'сообщений'), $current_unread) ?>
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                        <?php if ($i % 2 != 0 && $i != 3):?>
                                            </tr>
                                            <tr>
                                        <?php endif ?>
                                <?php $unreadShown += $current_unread; ?>
                                <?php endfor; ?>

                            </tr>

                        </table>

                        <?php if (count($dialogUsers) > 4):?>
                            <div style="margin:10px 0;text-align:center;font:20px arial, helvetica, sans-serif;color:#0483e0;">
                                <a href="http://www.happy-giraffe.ru/user/<?=$user->id ?>/?im_type=<?=Im::IM_CONTACTS_NEW ?>&token=<?= $token->content ?>&utm_source=email" style="font:20px arial, helvetica, sans-serif;color:#0483e0;">... еще <?= $unread - $unreadShown ?> <?= HDate::GenerateNoun(array('сообщение', 'сообщения', 'сообщений'), $unread - $unreadShown) ?></a></span>
                            </div>
                        <?php endif ?>

                    </td>
                </tr>

            </table>

            <table width="700" style="margin:40px auto 0;border-collapse: collapse; background: #ffffff;" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>

                        <div style="font:13px arial, helvetica, sans-serif;color:#232323;line-height:16px;margin-bottom:20px;">
                            С наилучшими пожеланиями,<br/>
                            <span style="color: #3587ec;"><a href="http://www.happy-giraffe.ru/?token=<?=$token->content ?>" target="_blank" style="color: #3587ec;">Веселый Жираф</a></span>
                        </div>


                    </td>
                </tr>


                <tr>
                    <td style="border-top:1px solid #e6e5e5;padding:6px 0;">

                        <p style="font:10px tahoma, arial, sans-serif; color: #979696;">Это письмо было сгенерированно автоматически. Пожалуйста не отвечайте на него. Если вы хотите обратиться в службу поддержки сайта «Веселый Жираф», напишите нам по адресу <span style=" color: #3587ec;"><a href="" target="_blank" style="color: #3587ec;">support@happy-giraffe.ru</a></span><br/>
                            <br/>
                            Вы получили это письмо, так как являетесь пользователем сайта "Веселый Жираф". Если вам не понравилось содержание ваших сообщений, просто проигнорируйте их.
                        </p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <tr><td height="20"><img src="http://www.happy-giraffe.ru/images/mail/blank.gif" height="20" width="100%" border="0"/></td></tr>

    </tbody>
</table>