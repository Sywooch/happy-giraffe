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

    public static function setAvatar(\User $user, Photo $photo, $cropData = null)
    {
        if ($cropData === null) {
            $cropData = array(
                'x' => 0,
                'y' => 0,
                'w' => $photo->width,
                'h' => $photo->height,
            );
        }

        $response = \CJSON::decode(\Yii::app()->api->request('photo/crops', 'create', array(
            'photoId' => $photo->id,
            'cropData' => $cropData,
        )));

        if ($response['success'] == true) {
            $user->avatarId = $response['data']['id'];
            foreach (self::$_sizeToPreset as $size => $presetName) {
                $user->avatarObject->$size = \Yii::app()->crops->getCrop($photo, self::$_sizeToPreset[$size], $cropData, $response['data']['fsName'])->getUrl();
            }
            $user->avatarInfo = $user->avatarObject->serialize();
            return ($user->save(false, array('avatarId', 'avatarInfo'))) ? $user->avatarObject : false;
        }
        return false;
    }

    public static function removeAvatar(\User $user)
    {
        $oldAvatarId = $user->avatarId;
        if ($oldAvatarId === null) {
            return true;
        }

        $user->avatarInfo = null;
        $user->avatarId = null;
        if ($user->save(false, array('avatarInfo', 'avatarId'))) {
            \Yii::app()->api->request('photo/crops', 'remove', array(
                'id' => $oldAvatarId,
            ));
            return true;
        }
        return false;
    }

    public static function getAvatar(\User $user, $width)
    {
        if ($user->avatarId === null) {
            return null;
        }

        foreach (self::$_sizeToPreset as $size => $presetName) {
            $presetWidth = \Yii::app()->crops->presets[$presetName]['width'];
            if ($width <= $presetWidth || end(self::$_sizeToPreset) == $presetName) {
                return self::getAvatarBySize($user, $size);
            }
        }
    }

    public static function refreshAvatar(\User $user)
    {
        if ($user->avatarId === null) {
            return false;
        }

        $crop = \CJSON::decode(\Yii::app()->api->request('photo/crops', 'get', array(
            'id' => $user->avatarId,
        )));

        $cropData = array(
            'x' => $crop['data']['x'],
            'y' => $crop['data']['y'],
            'w' => $crop['data']['w'],
            'h' => $crop['data']['h'],
        );

        $photo = Photo::model()->findByPk($crop['data']['photoId']);

        foreach (self::$_sizeToPreset as $size => $presetName) {
            \Yii::app()->crops->getCrop($photo, self::$_sizeToPreset[$size], $cropData, $crop['data']['fsName'], true);
        }

        return true;
    }

    protected static function getAvatarBySize(\User $user, $size)
    {
        return $user->avatarObject->$size;
    }
} 