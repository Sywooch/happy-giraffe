<?php
/**
 * @author Никита
 * @date 01/03/17
 */

namespace site\frontend\modules\geo2\components\fias;


class FileNameHelper
{
    public static function filenameToTable($filename)
    {
        $parts = explode('_', $filename);
        return $parts[1];
    }
}