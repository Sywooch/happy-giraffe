<?php
/**
 * @author Никита
 * @date 19/12/14
 */

namespace site\frontend\modules\users;


use site\frontend\modules\users\models\User;

class AvatarManager
{
    public static function setAvatar($userId, $photoId, $cropData)
    {
        $user = User::model()->findByPk($userId);
        if ($user === null) {
            return false;
        }

        $crop = \Yii::app()->api->request('photo/photos', 'createCrop', compact('photoId', 'cropData'));


    }
} 