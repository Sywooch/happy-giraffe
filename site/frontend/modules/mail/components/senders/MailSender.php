<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 04/04/14
 * Time: 10:40
 * To change this template use File | Settings | File Templates.
 */

abstract class MailSender extends CComponent
{
    const FROM_NAME = 'Весёлый Жираф';
    const FROM_EMAIL = 'noreply@happy-giraffe.ru';

    abstract public function sendAll();
    abstract public function send($userId);

    protected function sendInternal(User $user, MailMessage $message)
    {
        if ($user->online)
            return false;
        else {
            if (ElasticEmail::send($user->email, $message->getSubject(), $message->getBody(), self::FROM_EMAIL, self::FROM_NAME)) {
                $this->createDelivery($message);
            }
        }
    }

    protected function createDelivery(MailMessage $message)
    {
        $delivery = new MailDelivery();
        $delivery->user_id = $message->userId;
        $delivery->type = $message->type;
        $delivery->save();
        return $delivery;
    }
}