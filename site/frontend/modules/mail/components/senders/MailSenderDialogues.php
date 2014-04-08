<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 04/04/14
 * Time: 15:22
 * To change this template use File | Settings | File Templates.
 */

class MailSenderDialogues extends MailSender
{
    public function sendAll()
    {
        $user = User::model()->findByPk(12936);
        $message = new MailMessageDialogues($user);
        $this->sendInternal($message);
    }
}