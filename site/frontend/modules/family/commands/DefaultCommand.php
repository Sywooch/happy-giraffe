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
        \Yii::app()->gearman->worker()->addFunction('updateMember', array($this, 'updateMember'));

        while (\Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }

    public function updateMember(\GearmanJob $job)
    {
        $userId = $job->workload();
        /** @var \site\frontend\modules\family\models\FamilyMember $member */
        $member = \site\frontend\modules\family\models\FamilyMember::model()->user($userId)->find();
        if ($member !== null) {
            $member->updateByUser();
        }
    }
} 