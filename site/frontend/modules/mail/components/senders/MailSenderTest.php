<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 15/04/14
 * Time: 17:43
 * To change this template use File | Settings | File Templates.
 */

class MailSenderTest extends MailMassSender
{
    public function process(User $user)
    {
        return new MailMessageTest($user);
    }
}