<?php

namespace site\frontend\modules\rss\components\channels;

/**
 * @author Никита
 * @date 12/12/14
 */

class CommentsRssChannel extends RssChannelAbstract
{
    public function __construct($user)
    {
        if (! $user instanceof \User) {
            $user = \User::model()->findByPk($user);
            if ($user === null) {
                throw new \CException('Invalid user id');
            }
        }
        $this->user = $user;
        parent::__construct();
    }

    public function getDataProvider()
    {
        return new \CActiveDataProvider('site\frontend\modules\comments\models\Comment', array(
            'criteria' => new \CDbCriteria(array(
                'join' => 'LEFT OUTER JOIN community__contents c ON c.id = t.entity_id AND (t.entity = "CommunityContent" OR t.entity = "BlogContent")',
                'condition' => 'c.author_id = :userId AND c.removed = 0',
                'params' => array(':userId' => $this->user->id),
                'order' => 't.created DESC',
            )),
        ));
    }

    public function getTitle()
    {
        return 'Комментарии из блога - ' . $this->user->getFullName();
    }

    public function getLink()
    {
        return \Yii::app()->createAbsoluteUrl('/blog/default/index', array('user_id' => $this->user->id));
    }

    public function getUrl($page = 0)
    {
        return \Yii::app()->createAbsoluteUrl('/rss/default/comments/', array('userId' => $this->user->id));
    }

    public function getChannelTags()
    {
        return array(
            'generator' => 'MyBlogEngine 1.1:comments',
            'category' => 'ya:comments',
        );
    }
} 