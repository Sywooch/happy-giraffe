<?php
/**
 * @author Никита
 * @date 19/11/14
 */

namespace site\frontend\modules\family\commands;

use site\frontend\modules\family\components\MigrateManager;

class MigrateCommand extends \CConsoleCommand
{
    public function actionSingle($userId)
    {
        MigrateManager::migrateSingle($userId);
    }
} 