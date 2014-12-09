<?php

namespace site\frontend\modules\rss\controllers;
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

        $feed = new \EFeed();
        $dataProvider = new \CActiveDataProvider('site\frontend\modules\posts\models\Content', array(
            'criteria' => new \CDbCriteria(array(
                'condition' => 'authorId = :authorId',
                'params' => array(':authorId' => $userId),
                'order' => 'dtimeCreate DESC',
            )),
        ));
        FeedGenerator::fill($feed, $dataProvider, $page);
        $feed->setTitle('Блог пользователя ' . $user->getFullName());
        $feed->setLink($this->createAbsoluteUrl('/blog/default/index', array('user_id' => $user->id)));
        $feed->setDescription(($user->blog_title === null) ? 'Блог - ' . $user->getFullName() : $user->blog_title);
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1');
        $feed->addChannelTag('wfw:commentRss', $this->createAbsoluteUrl('/rss/default/comments', array('userId' => $user->id)));
        if ($dataProvider->pagination->pageCount > ($page + 1)) {
            $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('/rss/default/user', array('userId' => $user->id, 'page' => $page + 1)));
        }
        $feed->addChannelTag('image', array('url' => $user->getAvatarUrl(), 'width' => 72, 'height' => 72));
        $feed->generateFeed();
    }

    public function actionComments($userId, $page = 0)
    {
        $feed = new \EFeed();
        $dataProvider = new \CActiveDataProvider('site\frontend\modules\comments\models\Comment', array(
            'criteria' => new \CDbCriteria(array(
                'join' => 'LEFT OUTER JOIN community__contents c ON c.id = t.entity_id AND (t.entity = "CommunityContent" OR t.entity = "BlogContent")',
                'condition' => 'c.author_id = :userId AND c.removed = 0',
                'params' => array(':userId' => $userId),
                'order' => 't.created DESC',
            )),
        ));
        FeedGenerator::fill($feed, $dataProvider, $page);
        $feed->setLink($this->createAbsoluteUrl('/blog/default/index', array('user_id' => $userId)));
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1:comments');
        if ($dataProvider->pagination->pageCount > ($page + 1)) {
            $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('/rss/default/comments', array('userId' => $userId, 'page' => $page + 1)));
        }
        $feed->addChannelTag('category', 'ya:comments');
        $feed->generateFeed();
    }
} 