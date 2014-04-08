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
        $dp = new CActiveDataProvider('User');
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $user) {
            $total = MessagingManager::unreadMessagesCount($user->id);
            if ($total > 0) {

            }
        }
    }

    public function send($userId)
    {

    }
}