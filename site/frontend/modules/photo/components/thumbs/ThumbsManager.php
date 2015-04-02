<?php
/**
 * Менеджер миниатюр
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\components\thumbs\filters\CustomFilterInterface;
use site\frontend\modules\photo\models\Photo;

abstract class ThumbsManager extends \CApplicationComponent
{
    protected function getThumbInternal(Photo $photo, CustomFilterInterface $filter, $path, $animated, $replace)
    {
        $thumb = new Thumb($photo, $filter, $path, $animated);
        if (! \Yii::app()->fs->has($path) || $replace) {
            die('123');
            \Yii::app()->fs->write($path, $thumb->get(), true);
        }
        return $thumb;
    }
}