<?php

class Notification
{

    const NOTIFICATION_RECORD = 0;
    const NOTIFICATION_COMMENT = 1;
    const NOTIFICATION_REPLY = 2;

    public static $nouns = array(
        self::NOTIFICATION_RECORD => array(
            'Новая запись',
            'новая запись',
            'новых записи',
            'новых записей',
        ),
        self::NOTIFICATION_COMMENT => array(
            'Новый комментарий',
            'новый комментарий',
            'новых комментария',
            'новых комментариев',
        ),
        self::NOTIFICATION_REPLY => array(
            'Новый ответ',
            'новый ответ',
            'новых ответа',
            'новых ответов',
        ),
    );

    public function parse($int, $noun)
    {
        $a = $int % 10;
        $b = $int % 100;

        if (($b >= 11 && $b <= 14) || (($a >= 5 && $a <= 9) || $a == 0)) {
            $suffix = 3;
        } elseif ($a == 1) {
            $suffix = 1;
        } elseif ($a >= 2 && $a <= 4) {
            $suffix = 2;
        }

        return ($int == 1) ? self::$nouns[$noun][0] : $int . ' ' . self::$nouns[$noun][$suffix];
    }
}
