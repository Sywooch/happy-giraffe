<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 16/06/14
 * Time: 10:43
 */

class MailMessageTest extends MailMessage
{
    public $type = 'test';

    public function getSubject()
    {
        return 'Тестовое сообщение';
    }
} 