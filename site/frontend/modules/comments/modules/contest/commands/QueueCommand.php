<?php
namespace site\frontend\modules\comments\modules\contest\commands;

use site\frontend\modules\comments\modules\contest\components\CommentsHandler;

class QueueCommand extends \CConsoleCommand
{
    public function actionWorker()
    {
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();

        \Yii::app()->gearman->worker()->addFunction('handleComment', function (\GearmanJob $job) {
            $workload = $job->workload();
            call_user_func_array(array('site\frontend\modules\comments\modules\contest\components\CommentsHandler', 'handle'), unserialize($workload));
        });
        while (\Yii::app()->gearman->worker()->work()) {
            echo "ok\n";
        };
    }
}