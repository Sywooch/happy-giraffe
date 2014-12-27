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
        $user = User::model()->findByPk($userId);
        Manager::convertAvatar($user);
    }

    public function actionAvatarSingle($userId)
    {
        $user = User::model()->findByPk($userId);
        Manager::convertAvatar($user);
    }

    public function actionAvatarAll()
    {
        $dp = new \CActiveDataProvider('site\frontend\modules\users\models\User', array(
            'criteria' => array(
                'condition' => 'avatar_id IS NOT NULL AND avatarId IS NULL',
                'order' => 'id ASC',
            )
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        $total = $dp->totalItemCount;
        foreach ($iterator as $i => $user) {
            Manager::convertAvatar($user);
            echo $i . '/' . $total . "\n";
        }
    }

    public function actionFillQueue()
    {
        $dp = new \CActiveDataProvider('site\frontend\modules\users\models\User', array(
            'criteria' => 'id ASC',
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        foreach ($iterator as $user) {
            \Yii::app()->gearman->client()->doBackground('migrateUser', $user->id);
        }
    }

} 