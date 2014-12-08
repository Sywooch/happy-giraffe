<?php

namespace site\frontend\modules\rss\controllers;
use site\frontend\modules\rss\components\FeedGenerator;

/**
 * @author Никита
 * @date 28/11/14
 */

class DefaultController extends \HController
{
    public function actionUser($userId)
    {
        $dataProvider = new \CActiveDataProvider('site\frontend\modules\posts\models\Content', array(
            'criteria' => new \CDbCriteria(array(
                'condition' => 'authorId = :authorId',
                'params' => array(':authorId' => $userId),
                'order' => 'dtimeCreate DESC',
            )),
        ));
        $feed = new FeedGenerator($dataProvider);
        $feed->run();
    }

    public function actionComments($userId, $page = 0)
    {
        $dataProvider = new \CActiveDataProvider('site\frontend\modules\comments\models\Comment', array(
            'criteria' => new \CDbCriteria(array(
                'join' => 'LEFT OUTER JOIN community__contents c ON c.id = t.entity_id AND (t.entity = "CommunityContent" OR t.entity = "BlogContent")',
                'condition' => 'c.author_id = :userId AND c.removed = 0',
                'params' => array(':userId' => $userId),
                'order' => 't.created DESC',
            )),
        ));
        $feed = new FeedGenerator();
        $feed->fill($dataProvider, $page);
        $feed->feed->setLink($this->createAbsoluteUrl('/blog/default/index', array('user_id' => $userId)));
        $feed->feed->generateFeed();
    }
} 