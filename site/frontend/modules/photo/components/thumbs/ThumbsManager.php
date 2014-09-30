<?php
/**
 * Менеджер миниатюр
 */

namespace site\frontend\modules\photo\components\thumbs;

use site\frontend\modules\photo\components\thumbs\filters\CustomFilterInterface;
use site\frontend\modules\photo\models\Photo;

class ThumbsManager extends \CApplicationComponent
{
    protected function getThumbInternal(Photo $photo, CustomFilterInterface $filter, $path, $animated, $replace)
    {
        $thumb = new Thumb($photo, $filter, $path, $animated);
        if (\Yii::app()->fs->has($path) || $replace) {
            \Yii::app()->fs->write($path, $thumb->getImage()->get('gif'), true);
        }
        return $thumb;
    }
}