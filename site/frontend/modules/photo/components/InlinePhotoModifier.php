<?php
/**
 * Класс для быстрых операций с фото
 *
 * @author Никита
 * @date 03/10/14
 * @todo Класс-инвалид. Удалить ASAP.
 */

namespace site\frontend\modules\photo\components;
use Imagine\Imagick\Imagine;
use site\frontend\modules\photo\models\Photo;

class InlinePhotoModifier extends \CComponent
{
    const ROTATE_LEFT = 0;
    const ROTATE_RIGHT = 1;

    /**
     * Повернуть фото
     * @param Photo $photo
     * @param int $angle
     * @return bool
     */
    public static function rotate(Photo $photo, $angle)
    {
        $imagine = new Imagine();
        $image = $imagine->load(\Yii::app()->fs->read($photo->getOriginalFsPath()));
        $image->rotate($angle);
        $photo->imageUpdated();
        \Yii::app()->fs->write($photo->getOriginalFsPath(), $image->get('jpg'));
        return true;
    }
} 