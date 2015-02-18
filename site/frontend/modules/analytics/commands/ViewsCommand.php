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
    public function init()
    {
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        parent::init();
    }

    public function actionWorker()
    {
        $vm = new VisitsManager();
        \Yii::app()->gearman->worker()->addFunction('processUrl', function(\GearmanJob $job) use ($vm) {
            echo $job->workload() . "\n";
            $vm->processUrl($job->workload());
        });
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

    public function actionTest()
    {
        $model = PageView::model()->find();
        var_dump(0 > $model->synced);
    }
} 