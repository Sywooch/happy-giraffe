<?php
/**
 * @author Никита
 * @date 19/12/14
 */

namespace site\frontend\modules\users\components;


use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\users\models\User;

class AvatarManager
{
    const SIZE_SMALL = 'small';
    const SIZE_MEDIUM = 'medium';
    const SIZE_BIG = 'big';

    private static $_sizeToPreset = array(
        self::SIZE_SMALL => 'avatarSmall',
        self::SIZE_MEDIUM => 'avatarMedium',
        self::SIZE_BIG => 'avatarBig',
    );

    public static function setAvatar(\User $user, Photo $photo, $cropData)
    {
        $crop = \CJSON::decode(\Yii::app()->api->request('photo/crops', 'create', array(
            'photoId' => $photo->id,
            'cropData' => $cropData,
        )));

        if ($crop['success'] == true) {
            $user->avatarId = $crop['data']['id'];
            foreach (self::$_sizeToPreset as $size => $presetName) {
                $user->avatarObject->$size = \Yii::app()->crops->getCrop($photo, self::$_sizeToPreset[$size], $cropData, $crop['data']['fsName'])->getUrl();
            }
            return ($user->save()) ? $user->avatarObject : false;
        }
        return false;
    }

    public static function removeAvatar(\User $user)
    {
        $user->avatarInfo = null;
        $user->avatarId = null;
        return $user->save();
    }

    public static function getAvatar(\User $user, $width)
    {
        if ($user->avatarId === null) {
            return null;
        }

        $outputSize = null;
        foreach (self::$_sizeToPreset as $size => $presetName) {
            $presetWidth = \Yii::app()->crops->presets[$presetName]['width'];
            $diff = abs($width - $presetWidth);
            if (! isset($minDiff) || $diff < $minDiff) {
                $minDiff = $diff;
                $outputSize = $size;
            }
        }
        return self::getAvatarBySize($user, $outputSize);
    }

    protected static function getAvatarBySize(\User $user, $size)
    {
        return $user->avatarObject->$size;
    }
} 