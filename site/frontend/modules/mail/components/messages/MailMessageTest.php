<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 15/04/14
 * Time: 17:46
 * To change this template use File | Settings | File Templates.
 */

class MailMessageTest extends MailMessage
{
    public $type = 'test';

    public function getSubject()
    {
        return 'Тестовый заголовок';
    }
}