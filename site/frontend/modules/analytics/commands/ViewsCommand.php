<?php
namespace site\frontend\modules\analytics\commands;
use site\frontend\modules\analytics\components\MigrateManager;
use site\frontend\modules\analytics\components\VisitsManager;
use site\frontend\modules\analytics\models\PageView;

/**
 * @author Никита
 * @date 26/01/15
 */

class ViewsCommand extends \CConsoleCommand
{
    public function actionIndex()
    {
        $vm = new VisitsManager();
        $vm->inc();
        //$vm->sync('\site\frontend\modules\posts\models\Content');
    }

    public function actionMigrate()
    {
        $manager = new MigrateManager();
        $manager->run();
    }
} 