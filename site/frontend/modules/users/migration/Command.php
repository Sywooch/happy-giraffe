<?php

namespace site\frontend\modules\users\migration;

/**
 * @author Никита
 * @date 25/12/14
 */

class Command extends \CConsoleCommand
{
    public function actionAvatarSingle($userId)
    {
        $user = \User::model()->findByPk($userId);
        Manager::convertAvatar($user);
    }

} 