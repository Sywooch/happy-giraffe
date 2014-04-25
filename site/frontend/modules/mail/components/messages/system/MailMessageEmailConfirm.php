<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/04/14
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */

class MailMessageEmailConfirm extends MailMessage
{
    public function getSubject()
    {
        return 'Подтверждение e-mail - Весёлый Жираф';
    }
}