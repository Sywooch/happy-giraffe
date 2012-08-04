<?php
/* @var $user User
 * @var $unread int
 * @var $dialogUsers DialogUser[]
 */
?>
<div
    style="margin:30px 0;text-align:center;font:25px arial, helvetica, sans-serif;color:#2a2a2a;">
    У вас <?=$unread ?> новых <?=HDate::GenerateNoun(array('сообщение', 'сообщения', 'сообщений'), $unread) ?>!
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
                            <img src="<?=$dialogUser->user->getAvaOrDefaultImage() ?>" style="display:block;-moz-border-radius:36px;-webkit-border-radius:36px;border-radius:36px;"/>
                        </td>
                        <td valign="top">
                            <span style="color:#38a5f4;font:12px/16px arial, helvetica, sans-serif;"><?=$dialogUser->user->getFullName() ?></span><br/>
                            <?php if (!empty($dialogUser->user->getUserAddress()->country_id)):?>
                                <span style="color:#858484;font:9px/18px tahoma, helvetica, sans-serif;"><img src="http://www.happy-giraffe.ru/images/mail/flags/<?= $dialogUser->user->getUserAddress()->country->iso_code; ?>0018.gif" style="margin-right:5px;"><?php echo CHtml::encode($dialogUser->user->getUserAddress()->getCityName()); ?></span><br/>
                            <?php endif ?>
                            <?php if (!empty($dialogUser->user->status->text)):?>
                                <span style="color:#2aa908;font:11px/18px tahoma, helvetica, sans-serif;"><?=$dialogUser->user->status->text ?></span><br/>
                            <?php endif ?>
                            <span style="color:#0d81d5;font:18px/20px arial, helvetica, sans-serif;">
                                <a href="<?=Yii::app()->createAbsoluteUrl('/im/default/dialog', array('id'=>$dialogUser->dialog_id)) ?>" target="_blank" style="color:#0d81d5;font:18px/20px arial, helvetica, sans-serif;"><?=$current_unread = Dialog::getUnreadMessagesCount($dialogUser->dialog_id) ?> <?=HDate::GenerateNoun(array('сообщение', 'сообщения', 'сообщений'), $current_unread) ?></a>
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
        <a href="<?=Yii::app()->createAbsoluteUrl('/im/default/new') ?>" style="font:20px arial, helvetica, sans-serif;color:#0483e0;">... еще <?=$unread - $unreadShown ?> <?=HDate::GenerateNoun(array('сообщение', 'сообщения', 'сообщений'), $unread - $unreadShown) ?></a></span>
    </div>
<?php endif ?>