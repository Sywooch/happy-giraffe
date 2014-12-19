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
        $crop = \CJSON::decode(\Yii::app()->api->request('photo/photos', 'createCrop', array(
            'photoId' => $photo->id,
            'cropData' => $cropData,
        )));
        if ($crop['success'] == true) {
            $user->avatarId = $crop['data']['id'];
            foreach (self::$_sizeToPreset as $size => $presetName) {
                $user->avatarObject->$size = \Yii::app()->crops->getCrop($photo, self::$_sizeToPreset[$size], $cropData, $crop['data']['fsName'])->getUrl();
            }

            var_dump($user->avatarObject); die;

            $user->update();
        }
    }
} 