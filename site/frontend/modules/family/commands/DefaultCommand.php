<?php
/**
 * @author Никита
 * @date 23/10/14
 */

class DefaultCommand extends CConsoleCommand
{
    /**
     * Основной воркер, должен быть всегда запущен для корректной работы приложения.
     */
    public function actionWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('deferredWrite', array($this, 'deferredWrite'));
        \Yii::app()->gearman->worker()->addFunction('createThumbs', array($this, 'createThumbs'));

        while (\Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }

    public function updateMember(\GearmanJob $job)
    {
        $data = unserialize($job->workload());
        $key = $data['key'];
        $content = $data['content'];
        \Yii::app()->fs->getAdapter()->getSource()->write($key, $content);
        echo "deferredWrite:\n$key\n\n";
    }
} 