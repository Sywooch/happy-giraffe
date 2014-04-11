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
    public function __construct()
    {
        Yii::import('site.frontend.modules.messaging.components.*');
        Yii::import('site.frontend.modules.messaging.models.*');
    }

    protected function process(User $user)
    {
        if ($user->online && self::SENDER_DEBUG === false)
            return null;

        if (self::SENDER_DEBUG) {
            $lastDelivery = null;
        } else {
            $lastDelivery = MailDelivery::model()->getLastDelivery($user->id, 'dialogues');
        }
        $after = $lastDelivery === null ? null : $lastDelivery->created;
        $messagesCount = MessagingManager::unreadMessagesCount($user->id, array(
            'with' => array(
                'message' => array(
                    'joinType' => 'INNER JOIN',
                    'scopes' => array(
                        'newer' => $after,
                    ),
                ),
            ),
        ));

        if ($messagesCount > 0) {
            $contacts = ContactsManager::getContactsForDelivery($user->id, 5, $after);
            $contactsCount = ContactsManager::getContactsForDeliveryCount($user->id, $after);
            return new MailMessageDialogues($user, compact('contacts', 'messagesCount', 'contactsCount'));
        }

        return null;
    }
}