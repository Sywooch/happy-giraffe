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
            $messagesCount = MessagingManager::unreadMessagesCount($user->id);
            if ($messagesCount == 0)
                break;

            $lastDelivery = MailDelivery::model()->getLastDelivery($user->id, 'dialogues');
            $after = $lastDelivery === null ? null : $lastDelivery->sent;
            $contacts = ContactsManager::getContactsForDelivery($user->id, 5, $after);
            $contactsCount = ContactsManager::getContactsForDeliveryCount($user->id, $after);


        }
    }
}