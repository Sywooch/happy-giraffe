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
    public function actionPopulateFrom($lastDays)
    {
        $criteria = new \CDbCriteria();
        if ($lastDays) {
            $criteria->addCondition('created > :created');
            $criteria->params[':created'] = date("Y-m-d H:i:s", strtotime('-' . (int) $lastDays . ' day'));
        }

        $dp = new \CActiveDataProvider(Content::model(), array(
            'criteria' => $lastDays,
        ));

        $iterator = new \CDataProviderIterator($dp, 100);

        foreach ($iterator as $i) {
            FeedManager::handle($i);
        }
    }

    public function actionTest()
    {
        $post = Content::model()->byEntity('CommunityContent', 52306)->find();
        FeedManager::handle($post);
    }
}