<?php
namespace site\frontend\modules\users\commands;
use site\frontend\modules\users\components\AvatarManager;

/**
 * @author Никита
 * @date 02/04/15
 */

class DefaultCommand extends \CConsoleCommand
{
    public function actionFix()
    {
        $user = \User::model()->findByPk(232714);

        AvatarManager::refreshAvatar($user);
    }
}