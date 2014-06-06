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

    public static function getMimeType($path)
    {
        if (function_exists('finfo_open'))
        {
            $mimeType = false;
            if ($info = finfo_open(defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME)) {
                $mimeType = finfo_file($info, $path);
            }
        }
        elseif (function_exists('mime_content_type')) {
            $mimeType = mime_content_type($path);
        }
        else {
            throw new \CException(\Yii::t('yii','In order to use MIME-type validation provided by CFileValidator fileinfo PECL extension should be installed.'));
        }

        return $mimeType;
    }
} 