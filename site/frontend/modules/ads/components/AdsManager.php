<?php
/**
 * @author Никита
 * @date 04/02/15
 */

namespace site\frontend\modules\ads\components;


class AdsManager
{
    public static function add(\CActiveRecord $model, $line, $template)
    {
        $creativeInfo = new CreativeInfoProvider($template, $model);

    }

    public static function update()
    {

    }

    public static function remove()
    {

    }

    public static function toggle()
    {

    }
}