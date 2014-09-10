<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 08/08/14
 * Time: 18:07
 */

namespace site\frontend\components;


class TrimFilter
{
    public static function trimTitle($string)
    {
        if (preg_match('#[^\.][\.]$#', $string)) {
            $string = rtrim($string, '.');
        }
        return $string;
    }
} 