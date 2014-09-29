<?php
/**
 * Менеджер миниатюр
 */

namespace site\frontend\modules\photo\components\thumbs;

use site\frontend\modules\photo\components\thumbs\filters\CustomFilterInterface;
use site\frontend\modules\photo\models\Photo;

class ThumbsManager extends \CApplicationComponent
{
    protected function getThumbInternal(Photo $photo, CustomFilterInterface $filter, $path, $replace = false)
    {
        $thumb = new Thumb($photo, $filter);
        if (\Yii::app()->fs->exists($path) || $replace) {
            \Yii::app()->fs->write($path, $thumb->getImage());
        }
        return $thumb;
    }
}