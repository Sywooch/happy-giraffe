<?php

namespace site\frontend\modules\users\migration;
use site\frontend\modules\photo\models\User;

/**
 * @author Никита
 * @date 25/12/14
 */

class Command extends \CConsoleCommand
{
    public function actionWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('convertAvatar', array($this, 'convertAvatar'));

        while (\Yii::app()->gearman->worker()->work());
    }

    public function convertAvatar(\GearmanJob $job)
    {
        $userId = $job->workload();
        $user = \User::model()->findByPk($userId);
        Manager::convertAvatar($user);
    }

    public function updateMember(\GearmanJob $job)
    {
        $userId = $job->workload();
        /** @var \site\frontend\modules\family\models\FamilyMember $member */
        $member = \site\frontend\modules\family\models\FamilyMember::model()->user($userId)->find();
        if ($member !== null) {
            $member->fillByUser($userId);
            $member->save();
        }
    }

    public function actionAvatarSingle($userId)
    {
        $user = \User::model()->findByPk($userId);
        Manager::convertAvatar($user);
    }

    public function actionAvatarAll()
    {
        $dp = new \CActiveDataProvider('User', array(
            'criteria' => 'id ASC',
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        foreach ($iterator as $user) {
            \Yii::app()->gearman->client()->doBackground('migrateUser', $user->id);
        }
    }

} 