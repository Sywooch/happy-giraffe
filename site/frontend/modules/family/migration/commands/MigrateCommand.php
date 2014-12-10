<?php
/**
 * @author Никита
 * @date 19/11/14
 */

namespace site\frontend\modules\family\migration\commands;

use site\frontend\modules\family\migration\components\MigrateManager;
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
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
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
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        MigrateManager::clean();

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

    public function actionPart()
    {
        $path = \Yii::getPathOfAlias('site.frontend.modules.family.migration') . DIRECTORY_SEPARATOR . 'list';
        $file = file($path);
        foreach ($file as $line) {
            $user = User::model()->findByPk($line);
            if ($user !== null) {
                MigrateManager::migrateSingle($user);
            } else {
                echo "Пользователь не найден\n";
            }
        }
    }

    public function actionClean()
    {
        MigrateManager::clean();
    }

    public function actionTest()
    {
        $dates = array('0000-00-00', null, '2012-12-00', '2014-12-31', '2015-12-31');
        foreach ($dates as $date) {
            var_dump(\site\frontend\modules\family\migration\components\MigrateManager::fixPregnancyDate($date));
            echo "\n";
        }
    }
}