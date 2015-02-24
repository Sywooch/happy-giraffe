<?php
namespace site\frontend\modules\comments\modules\contest\commands;

class QueueCommand extends \CConsoleCommand
{
    private $taskToMethod = array(
        'commentAdded' => 'added',
        'commentUpdated' => 'updated',
        'commentRemoved' => 'removed',
    );

    public function actionWorker()
    {
        foreach ($this->taskToMethod as $task => $method) {
            \Yii::app()->gearman->worker()->addFunction($task, function (\GearmanJob $job) use ($method) {
                $args = unserialize($job->workload());
                call_user_func_array(array('site\frontend\modules\comments\modules\contest\components\CommentsHandler', $method), $args);
            });
        }
        while (\Yii::app()->gearman->worker()->work()) {
            echo "ok\n";
        };
    }
}