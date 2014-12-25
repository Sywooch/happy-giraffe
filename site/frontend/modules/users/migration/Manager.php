<?php
/**
 * @author Никита
 * @date 25/12/14
 */

namespace site\frontend\modules\users\migration;


use site\frontend\modules\photo\components\MigrateManager;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoCrop;
use site\frontend\modules\users\components\AvatarManager;

class Manager
{
    public static function convertAvatar(\User $user)
    {
            if ($user->avatar_id === null || $user->avatarInfo != '') {
                return true;
            }

            if ($user->avatar->userAvatar) {
                $userAvatar = $user->avatar->userAvatar;
                $oldPhoto = $userAvatar->source;
                $photoId = MigrateManager::movePhoto($oldPhoto);
                $photo = Photo::model()->findByPk($photoId);
                $cropData = array(
                    'x' => $userAvatar->x,
                    'y' => $userAvatar->y,
                    'w' => $userAvatar->w,
                    'h' => $userAvatar->h,
                );
            } else {
                $oldPhoto = $user->avatar;
                $photoId = MigrateManager::movePhoto($oldPhoto);
                $photo = Photo::model()->findByPk($photoId);
                $cropData = array(
                    'x' => ($oldPhoto->width - 200) / 2,
                    'y' => ($oldPhoto->height - 200) / 2,
                    'w' => 200,
                    'h' => 200,
                );
            }

            return AvatarManager::setAvatar($user, $photo, $cropData);
    }
} 