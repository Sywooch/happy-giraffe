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
        return 'лол что' . time();
    }
}