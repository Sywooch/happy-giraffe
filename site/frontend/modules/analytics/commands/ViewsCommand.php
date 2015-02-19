<?php
namespace site\frontend\modules\analytics\commands;
use site\frontend\modules\analytics\components\MigrateManager;
use site\frontend\modules\analytics\components\VisitsManager;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 26/01/15
 */

class ViewsCommand extends \CConsoleCommand
{
    public function init()
    {
        ini_set('display_errors', true );
        error_reporting( E_ALL & ~E_NOTICE );
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
        $i = 0;
        while (true) {
            $i++;
            $post = Content::model()->find(array(
                'order' => 'RAND()',
            ));
            echo $i . "-" . $post->id . "\n";
        }
    }

    public function actionProcess($url)
    {
        $vm = new VisitsManager();
        $vm->processUrl($url);
    }
} 