<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/04/14
 * Time: 15:01
 * To change this template use File | Settings | File Templates.
 */

abstract class MailTransactionalSender extends MailSender
{
    public function send(User $user, $params = array())
    {
        $message = new MailSenderEmailConfirm($user, $params);
        $this->sendMessage($message);
    }
}