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
}