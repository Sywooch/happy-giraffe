<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 04/04/14
 * Time: 12:22
 * To change this template use File | Settings | File Templates.
 */

class MailMessageDialogues extends MailMessage
{
    public $type = 'dialogues';
    public $contacts;
    public $messagesCount;
    public $contactsCount;

    public function getSubject()
    {
        return 'У вас новые сообщения ' . time();
    }

    public function getTitle()
    {
        if ($this->contactsCount == 1) {
            $str = 'У вас одно непрочитанное сообщение.';
        } else {
            $str = 'У вас ' . $this->contactsCount . ' ' . Str::GenerateNoun(array(
                'непрочитанное сообщение',
                'непрочитанных сообщения',
                'непрочитанных сообщений',
            ), $this->contactsCount);
        }

        return parent::getTitle() . ' ' . $str . '.';
    }

    public function getMainUrlParams()
    {
        return array('/messaging/default/index', 'interlocutorId' => $this->contacts[count($this->contacts) - 1]->user->id);
    }
}