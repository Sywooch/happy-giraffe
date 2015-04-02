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
        $users = new \CActiveDataProvider('\User', array(
            'criteria' => array(
                'condition' => 'avatarId IS NOT NULL',
                'order' => 'id ASC',
            ),
        ));
        $i = new \CDataProviderIterator($users, 1000);

        foreach ($i as $user) {
            AvatarManager::refreshAvatar($user);
            echo "$i\n";
        }
    }
}