<?php

namespace site\frontend\modules\rss\components\channels;

/**
 * @author Никита
 * @date 12/12/14
 */

class UserRssChannel extends RssChannelAbstract
{
    protected $user;

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
        return new \CActiveDataProvider('site\frontend\modules\posts\models\Content', array(
            'criteria' => new \CDbCriteria(array(
                'condition' => 'authorId = :authorId',
                'params' => array(':authorId' => $this->user->id),
                'order' => 'dtimePublication DESC',
            )),
        ));
    }

    public function getChannelTags()
    {
        return array(
            'generator' => 'MyBlogEngine 1.1',
            'wfw:commentRss' => \Yii::app()->createAbsoluteUrl('/rss/default/comments', array('userId' => $this->user->id)),
            'image' => array('url' => $this->user->getAvatarUrl(), 'width' => 72, 'height' => 72),
        );
    }

    public function getTitle()
    {
        return 'Блог пользователя ' . $this->user->getFullName();
    }

    public function getLink()
    {
        return \Yii::app()->createAbsoluteUrl('/blog/default/index', array('user_id' => $this->user->id));
    }

    public function getUrl($page = 0)
    {
        return \Yii::app()->createAbsoluteUrl('/rss/default/user', array('userId' => $this->user->id));
    }

    public function getDescription()
    {
        return ($this->user->blog_title === null) ? 'Блог - ' . $this->user->getFullName() : $this->user->blog_title;
    }
} 