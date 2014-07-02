<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 06/06/14
 * Time: 14:34
 */

namespace site\frontend\modules\photo\components;


use Imagine\Gmagick\Imagine;
use site\frontend\modules\photo\models\Photo;

class InlinePhotoModifier extends \CComponent
{
    const ROTATE_LEFT = 0;
    const ROTATE_RIGHT = 1;

    public static function rotate(Photo $photo, $side)
    {
        $imagine = new Imagine();
        $image = $imagine->load($photo->getOriginalFsPath());
        $image->rotate($side == self::ROTATE_LEFT ? -90 : 90);
        \Yii::app()->getModule('photo')->fs->write($photo->getOriginalFsPath(), $image->get('jpg'));
    }
} 