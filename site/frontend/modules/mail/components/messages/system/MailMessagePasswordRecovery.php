<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/04/14
 * Time: 14:45
 * To change this template use File | Settings | File Templates.
 */

class MailMessagePasswordRecovery extends MailMessage
{
    public function getSubject()
    {
        return 'Напоминание пароля - Весёлый Жираф';
    }
}