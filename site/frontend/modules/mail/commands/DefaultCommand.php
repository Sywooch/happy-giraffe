<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 07/04/14
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */

class DefaultCommand extends CConsoleCommand
{
    public function init()
    {
        Yii::import('site.frontend.modules.mail.MailModule');
        new MailModule('mail', null);
        parent::init();
    }

    public function actionDialogues()
    {
        $sender = new MailSenderDialogues();
        $sender->sendAll();
    }
}