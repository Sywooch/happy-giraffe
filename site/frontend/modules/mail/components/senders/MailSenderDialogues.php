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
    public function send($userId)
    {
        $message = new MailMessageDialogues($userId);
    }

    public function sendAll()
    {
        $dp = new CActiveDataProvider('User');
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $user) {

        }
    }
}