<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/04/14
 * Time: 14:28
 * To change this template use File | Settings | File Templates.
 */

class MailSenderDaily extends MailSender
{
    public function process(User $user)
    {
        $horoscope = Horoscope::model()->findByAttributes(array(
            'zodiac' => Horoscope::model()->getDateZodiac($user->birthday),
            'date' => date("Y-m-d"),
        ));

        return new MailMessageDaily($user, compact('horoscope'));
    }
}