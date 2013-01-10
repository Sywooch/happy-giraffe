<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 12:17 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventStatus extends FriendEvent
{
    public $type = FriendEvent::TYPE_STATUS_UPDATED;
    public $content_id;

    private $_content;

    public function init()
    {
        $this->_content = $this->_getContent();
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function setContent($content)
    {
        $this->_content = $content;
    }

    private function _getContent()
    {
        return CommunityContent::model()->full()->findByPk($this->content_id);
    }

    public function getLabel()
    {
        return HDate::simpleVerb('Изменил', $this->user->gender) . ' статус';
    }

    public function createBlock()
    {
        $this->content_id = (int) $this->params['model']->id;
        $this->user_id = (int) $this->params['model']->author_id;

        parent::createBlock();
    }

    public function getExist()
    {
        return $this->content !== null;
    }

    public function canBeCached()
    {
        return true;
    }
}
