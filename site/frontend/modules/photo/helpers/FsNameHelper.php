<?php
/**
 * @author Никита
 * @date 19/12/14
 */

namespace site\frontend\modules\photo\helpers;


class FsNameHelper
{
    const FS_NAME_LEVELS = 2;
    const FS_NAME_SYMBOLS_PER_LEVEL = 2;

    public static function createFsName($hash)
    {
        $path = '';
        for ($i = 0; $i < self::FS_NAME_LEVELS; $i++) {
            $dirName = substr($hash, $i * self::FS_NAME_SYMBOLS_PER_LEVEL, self::FS_NAME_SYMBOLS_PER_LEVEL);
            $path .= $dirName . DIRECTORY_SEPARATOR;
        }
        $path .= substr($hash, self::FS_NAME_LEVELS * self::FS_NAME_SYMBOLS_PER_LEVEL);
        return $path;
    }
} 