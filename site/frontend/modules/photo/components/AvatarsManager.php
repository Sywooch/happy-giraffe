<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/09/14
 * Time: 17:20
 */

namespace site\frontend\modules\photo\components;


use site\frontend\modules\photo\models\Photo;

class AvatarsManager
{
    const SIZE_SMALL = 0;
    const SIZE_MEDIUM = 1;
    const SIZE_BIG = 2;

    public function setAvatar(\User $user, Photo $photo, array $cropData)
    {
        $crop = new \PhotoCrop();
        $crop->attributes = $cropData;
        $crop->photo_id = $photo->id;
        $crop->save();
    }

    public function getAvatar(\User $user, $size)
    {
        \Yii::app()->crops->getCrop
    }
} 