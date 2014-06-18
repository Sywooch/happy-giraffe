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
    public $type = 'dialogues';
    public $debugMode = self::DEBUG_PRODUCTION;

    public function __construct()
    {
        Yii::import('site.frontend.modules.messaging.components.*');
        Yii::import('site.frontend.modules.messaging.models.*');
    }

    protected function process(User $user)
    {
        echo $user->id . "\n";

        if (UserAttributes::get($user->id, 'dialogues', true) !== true) {
            return;
        }

        $messagesCount = MessagingManager::unreadMessagesCount($user->id, array(
            'with' => array(
                'message' => array(
                    'joinType' => 'INNER JOIN',
                    'scopes' => array(
                        'newer' => $this->lastDeliveryTimestamp,
                    ),
                ),
            ),
        ));

        if ($messagesCount > 0) {
            $contacts = ContactsManager::getContactsForDelivery($user->id, 5, $this->lastDeliveryTimestamp);
            $contactsCount = ContactsManager::getContactsForDeliveryCount($user->id, $this->lastDeliveryTimestamp);
            $message = new MailMessageDialogues($user, compact('contacts', 'messagesCount', 'contactsCount'));
            $this->send($message);
        }
    }

    protected function getUsersCriteria()
    {
        $criteria = parent::getUsersCriteria();
        return $criteria->compare('online', 0);
    }
}