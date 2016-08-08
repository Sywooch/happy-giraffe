<?php

namespace site\frontend\modules\comments\modules\contest\components;

class ContestHelper
{
    public static $pointsWords = array(
        'балл',
        'баллов',
        'балла',
    );

    public static $themeWords = array(
        'тема',
        'тем',
        'темы',
    );

    /**
     * @param string $url
     *
     * @return string
     */
    public static function getValidPostUrl($url)
    {
        $lastPart = explode('.ru', $url)[1];

        return \Yii::app()->request->hostInfo . $lastPart;
    }

    /**
     * @param int $number
     * @param array $words
     *
     * @return string
     */
    public static function getWord($number, $words)
    {
        $number = (string) $number;

        $length = strlen($number);

        $lastDigit = substr($number, $length - 1, 1);
        $penultDigit = '';

        if ($length > 1) {
            $penultDigit = substr($number, $length - 2, 1);
        }

        if ($length > 1 && $penultDigit == '1') {
            return $words[1];
        }

        if ($lastDigit == '1') {
            return $words[0];
        }

        if (in_array($lastDigit, array('2', '3', '4'))) {
            return $words[2];
        }

        return $words[1];
    }

    /**
     * @param int $time
     *
     * @return string
     */
    public static function getTimeString($time)
    {

    }
}