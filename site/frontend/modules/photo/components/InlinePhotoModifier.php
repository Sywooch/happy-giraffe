<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 06/06/14
 * Time: 14:34
 */

namespace site\frontend\modules\photo\components;


use Imagine\Imagick\Imagine;
use site\frontend\modules\photo\models\Photo;

class InlinePhotoModifier extends \CComponent
{
    const ROTATE_LEFT = 0;
    const ROTATE_RIGHT = 1;

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