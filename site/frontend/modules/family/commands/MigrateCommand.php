<?php
/**
 * @author Никита
 * @date 19/11/14
 */

namespace site\frontend\modules\family\commands;

use site\frontend\modules\family\components\MigrateManager;
use site\frontend\modules\family\models\Family;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoCollection;
use site\frontend\modules\users\models\User;

class MigrateCommand extends \CConsoleCommand
{
    public function actionAll($start = 1)
    {
        MigrateManager::migrateAll($start);
    }

    public function actionSingle($userId)
    {
        $user = User::model()->findByPk($userId);
        if ($user !== null) {
            MigrateManager::migrateSingle($user);
        } else {
            echo "Пользователь не найден\n";
        }
    }

    public function actionWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('migrateUser', array($this, 'migrateUser'));

        while (\Yii::app()->gearman->worker()->work());
    }

    public function migrateUser(\GearmanJob $job)
    {
        $userId = $job->workload();
        $user = User::model()->findByPk($userId);
        MigrateManager::migrateSingle($user);
    }

    public function actionFillQueue()
    {
        Family::model()->deleteAll();
        PhotoCollection::model()->deleteAll('entity = "Family"');
        PhotoCollection::model()->deleteAll('entity = "FamilyMember"');

        $dp = new \CActiveDataProvider('User', array(
            'criteria' => array(
                'order' => 'id ASC',
            ),
        ));

        $iterator = new \CDataProviderIterator($dp, 100);
        foreach ($iterator as $user) {
            \Yii::app()->gearman->client()->doBackground('migrateUser', $user->id);
        }
    }
