<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 06/06/14
 * Time: 14:59
 */

namespace site\frontend\modules\photo\components;


class FileHelper
{
    public static function getName($path)
    {
        if (($pos = strrpos($path, '/')) !== false) {
            return substr($path, $pos + 1);
        } else {
            return $path;
        }
    }

    public static function getExtensionName($path)
    {
        if (($pos = strrpos($path, '.')) !== false) {
            return substr($path, $pos + 1);
        }
        else {
            return '';
        }
    }
} 