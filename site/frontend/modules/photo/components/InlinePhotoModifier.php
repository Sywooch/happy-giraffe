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
use site\frontend\modules\photo\components\thumbs\ImageDecorator;
use site\frontend\modules\photo\models\Photo;

class InlinePhotoModifier extends \CComponent
{
    /**
     * Повернуть фото
     * @param Photo $photo
     * @param int $angle
     * @return bool
     */
    public static function rotate(Photo $photo, $angle)
    {
        $decorator = new ImageDecorator($photo->image, true);
        $decorator->rotate($angle);
        $photo->image = $decorator->get();
        return ($photo->save()) ? $photo : false;
    }
} 