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

    /**
     * Контакты для отображения
     *
     * @property MessagingContact[] $contacts
     */
    public $contacts;

    /**
     * Количество непрочитанных сообщений
     *
     * @property int $messagesCount
     */
    public $messagesCount;

    /**
     * Количество контактов, от которых есть непрочитанные сообщения
     *
     * @property int $contactsCount
     */
    public $contactsCount;

    public function getSubject()
    {
        $firstUser = $this->contacts[0]->user;
        if ($this->contactsCount == 1) {
            return $firstUser->first_name . ' ' . HDate::simpleVerb('написал', $firstUser->gender) . ' Вам сообщение';
        } elseif ($this->contactsCount == 2) {
            return $firstUser->first_name . ' и ' . $this->contacts[1]->user->first_name . ' написали Вам сообщения';
        } else {
            return $firstUser->first_name . ' и еще несколько человек написали Вам сообщения';
        }
    }

    public function getTitle()
    {
        if ($this->messagesCount == 1) {
            $str = 'У вас одно непрочитанное сообщение';
        } else {
            $str = 'У вас ' . $this->messagesCount . ' ' . Str::GenerateNoun(array(
                'непрочитанное сообщение',
                'непрочитанных сообщения',
                'непрочитанных сообщений',
            ), $this->messagesCount);
        }

        return parent::getTitle() . ' ' . $str . '.';
    }

    public function getMainUrlParams()
    {
        return array('/messaging/default/index', 'interlocutorId' => $this->contacts[0]->user->id);
    }
}