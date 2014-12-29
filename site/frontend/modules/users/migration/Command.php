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
        try {
            Manager::convertAvatar($user);
        } catch (\Exception $e) {
            echo $user->id . "\n";
        }
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
                'condition' => 'avatarId IS NULL',
                'join' => 'JOIN album__photos p ON p.id = t.avatar_id JOIN user__avatars a ON a.avatar_id = p.id',
                'order' => 't.id DESC',
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        $total = $dp->totalItemCount;
        foreach ($iterator as $i => $user) {
            echo $user->id . "\n";
            Manager::convertAvatar($user);
        }
    }

    public function actionFillQueue()
    {
        $dp = new \CActiveDataProvider('site\frontend\modules\users\models\User', array(
            'criteria' => array(
                'condition' => 'avatarId IS NULL',
                'join' => 'JOIN album__photos p ON p.id = t.avatar_id JOIN user__avatars a ON a.avatar_id = p.id',
                'order' => 't.id DESC',
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        foreach ($iterator as $user) {
            \Yii::app()->gearman->client()->doBackground('convertAvatar', $user->id);
        }
    }
} 