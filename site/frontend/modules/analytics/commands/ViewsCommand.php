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
        \Yii::app()->db->createCommand('SET SESSION net_write_timeout = 28800;')->execute();
        \Yii::app()->db->createCommand('SET SESSION net_read_timeout = 28800;')->execute();
        var_dump(\Yii::app()->db->createCommand('SHOW SESSION VARIABLES LIKE \'wait_timeout\';')->queryRow());
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
        $i = 0;
        while (true) {
            echo ++$i . "\n";
            sleep(1);
        }
    }
} 