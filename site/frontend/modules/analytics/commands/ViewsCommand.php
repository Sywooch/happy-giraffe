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
    public function actionWorker()
    {
        $vm = new VisitsManager();
        \Yii::app()->gearman->worker()->addFunction('updateMember', array($vm, 'processUrl'));
        while (\Yii::app()->gearman->worker()->work());
    }

    public function actionIndex()
    {
        $vm = new VisitsManager();
        $vm->inc();
    }

    public function actionMigrate()
    {
        $manager = new MigrateManager();
        $manager->run();
    }
} 