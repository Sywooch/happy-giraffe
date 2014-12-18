<?php

namespace site\frontend\modules\rss\controllers;
use site\frontend\modules\rss\components\channels\CommentsRssChannel;
use site\frontend\modules\rss\components\channels\UserRssChannel;
use site\frontend\modules\rss\components\FeedGenerator;

\Yii::import('ext.EFeed.*');

/**
 * @author Никита
 * @date 28/11/14
 */

class DefaultController extends \HController
{
    public function actionUser($userId, $page = 0)
    {
        /** @var \User $user */
        $user = \User::model()->findByPk($userId);
        if ($user === null || $user->id == \User::HAPPY_GIRAFFE) {
            throw new \CHttpException(404);
        }

        $channel = new UserRssChannel($user);
        $channel->render($page);
    }

    public function actionComments($userId, $page = 0)
    {
        $user = \User::model()->findByPk($userId);
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $channel = new CommentsRssChannel($user);
        $channel->render($page);
    }
} 