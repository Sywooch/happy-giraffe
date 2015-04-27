<?php
namespace site\frontend\modules\posts\modules\myGiraffe\commands;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\modules\myGiraffe\components\FeedManager;

/**
 * @author Никита
 * @date 17/04/15
 */

class DefaultCommand extends \CConsoleCommand
{
    public function actionPopulate($lastDays)
    {
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();

        $criteria = new \CDbCriteria();
        $criteria->addCondition('dtimeCreate > :created');
        $criteria->params[':created'] = strtotime('-' . $lastDays . ' day');

        $dp = new \CActiveDataProvider(Content::model(), array(
            'criteria' => $criteria,
        ));

        $iterator = new \CDataProviderIterator($dp, 100);

        foreach ($iterator as $i) {
            FeedManager::handle($i);
        }
    }

    public function actionUser($id)
    {
        FeedManager::updateForUser($id);
    }

    public function actionHandle($id)
    {
        $post = Content::model()->byEntity('CommunityContent', $id)->find();
        FeedManager::handle($post);
    }

    public function actionWorker()
    {
        \Yii::app()->gearman->worker()->addFunction('myGiraffeUpdateUser', function (\GearmanJob $job) {
            $workload = $job->workload();
            FeedManager::updateForUser($workload);
        });
        while (\Yii::app()->gearman->worker()->work());
    }
}