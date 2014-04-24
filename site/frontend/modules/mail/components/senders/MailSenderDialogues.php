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
    public $debugMode = self::DEBUG_TESTING;

    public function __construct()
    {
        Yii::import('site.frontend.modules.messaging.components.*');
        Yii::import('site.frontend.modules.messaging.models.*');
    }

    protected function process(User $user)
    {
        echo $user->id . " - ";

        $lastDelivery = MailDelivery::model()->getLastDelivery($user->id, 'dialogues');
        $after = $lastDelivery === null ? null : $lastDelivery->created;
        $messagesCount = MessagingManager::unreadMessagesCount($user->id, array(
            'with' => array(
                'message' => array(
                    'joinType' => 'INNER JOIN',
//                    'scopes' => array(
//                        'newer' => $after,
//                    ),
                ),
            ),
        ));

        echo $messagesCount . "\n";

//        if ($messagesCount > 0) {
//            $contacts = ContactsManager::getContactsForDelivery($user->id, 5, $after);
//            $contactsCount = ContactsManager::getContactsForDeliveryCount($user->id, $after);
//            $message = new MailMessageDialogues($user, compact('contacts', 'messagesCount', 'contactsCount'));
//            $this->sendMessage($message);
//        }
    }

    protected function getUsersCriteria()
    {
        $criteria = parent::getUsersCriteria();
        return $criteria->compare('online', 0);
    }
}