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

        if (! \Yii::app()->fs->has($path) || $replace)
        {
            try
            {
                \Yii::app()->fs->write($path, $thumb->get(), TRUE);
            }
            catch (\Exception $e)
            {
//                 \Yii::log(PHP_EOL . $e->getMessage() . PHP_EOL . 'See: ' . isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'REQUEST_URI not passed' . PHP_EOL, \CLogger::LEVEL_INFO, 'post attachment');

                $thumb = NULL;
            }
        }

        return $thumb;
    }
}