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

    public static $ids = [
        457198,
        175718,
        457158,
        458713,
        15814,
        15426,
        459499,
        436014,
        243290,
        458733,
        208514,
        462879,
        462875,
        462895,
        462959,
        462943,
        463529,
        463559,
        466068,
        15363,
        466088,
        429369,
        472033,
        457043,
        489726,
    ];

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
     * @return string
     */
    public static function getVkPostImage()
    {
        return 'photo9488596_433668714';
    }

    /**
     * @return string
     */
    public static function getFbPostImage()
    {
        return 'https://pp.vk.me/c637118/v637118596/e80c/PHwI3AOBR28.jpg';
    }

    /**
     * @return int
     */
    public static function getOkPostImage()
    {
        return /*838838369584*//*840062069455*/838960871748;
    }
}