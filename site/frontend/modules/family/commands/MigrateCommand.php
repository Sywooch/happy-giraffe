<?php
/**
 * @author Никита
 * @date 19/11/14
 */

namespace site\frontend\modules\family\commands;

use site\frontend\modules\family\components\MigrateManager;
use site\frontend\modules\users\models\User;

class MigrateCommand extends \CConsoleCommand
{
    public function actionAll($start = 1)
    {
        MigrateManager::migrateAll($start);
    }

    public function actionSingle($userId)
    {
        $user = User::model()->findByPk($userId);
        if ($user !== null) {
            MigrateManager::migrateSingle($user);
        } else {
            echo "Пользователь не найден\n";
        }
    }
} 