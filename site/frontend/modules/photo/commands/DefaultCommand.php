<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/07/14
 * Time: 14:29
 */

namespace site\frontend\modules\photo\commands;


use site\frontend\modules\photo\models\Photo;

class DefaultCommand extends \CConsoleCommand
{
    public function actionWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('defferedWrite', function($job) {
            $data = unserialize($job->workload());
            $key = $data['key'];
            $content = $data['content'];
            $adapter = $app->getModule('photo')->fs->getAdapter()->cache;
            $adapter->write($key, $content);
        });
        while (\Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }
} 