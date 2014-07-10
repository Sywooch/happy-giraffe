<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 10/07/14
 * Time: 15:42
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\components\thumbs\presets\PresetInterface;
use site\frontend\modules\photo\models\Photo;

class ThumbFactory
{
    private static $map = array(
        'jpg' => 'site\frontend\modules\photo\components\thumbs\ThumbJPG',
        'gif' => 'site\frontend\modules\photo\components\thumbs\ThumbGIF',
        'png' => 'site\frontend\modules\photo\components\thumbs\ThumbPNG',
    );

    /**
     * @param Photo $photo
     * @param PresetInterface $preset
     * @return Thumb
     * @throws \CException
     */
    public static function create(Photo $photo, PresetInterface $preset)
    {
        $format = pathinfo($photo->fs_name, PATHINFO_EXTENSION);
        if (! array_key_exists($format, self::$map)) {
            throw new \CException('Формат не поддерживается');
        }

        $class = self::$map[$format];
        $object = new $class();
        $object->photo = $photo;
        $object->preset = $preset;
        $object->format = $format;
        return $object;
    }
} 