<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 04/04/14
 * Time: 10:40
 * To change this template use File | Settings | File Templates.
 */

class MailSender
{
    const FROM_NAME = 'Весёлый Жираф';
    const FROM_EMAIL = 'noreply@happy-giraffe.ru';

    /**
     * Отправляет пользователю письмо определенного типа
     *
     * @param $userId
     * @param $type
     */
    public function send($userId, $type)
    {
        $message = MailMessageFactory::create($userId, $type);
    }
}