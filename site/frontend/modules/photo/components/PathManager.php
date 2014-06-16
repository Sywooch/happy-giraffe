<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/06/14
 * Time: 12:30
 */

namespace site\frontend\modules\photo\components;


class PathManager
{
    const ROOT_ALIAS = 'site.common.uploads.photos.v2';

    public static function getRootPath()
    {
        return \Yii::getPathOfAlias(self::ROOT_ALIAS);
    }

    public static function getOriginalsPath()
    {
        return \Yii::getPathOfAlias(self::ROOT_ALIAS . '.originals');
    }
} 