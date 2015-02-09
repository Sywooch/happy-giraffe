<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:40 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventPost extends FriendEvent
{
    public $type = FriendEvent::TYPE_POST_ADDED;
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
        return CommunityContent::model()->findByPk($this->content_id);
    }

    public function getLabel()
    {


        return HDate::simpleVerb('Добавил', $this->user->gender) . ' ' . $this->typeString;
    }

    public function getTypeString()
    {
        switch ($this->content->type_id) {
            case 1:
                return 'запись';
                break;
            case 2:
                return 'видео';
                break;
            default:
                return 'пост';
        }
    }

    public function createBlock()
    {
        $this->content_id = (int)$this->params['model']->id;
        $this->user_id = (int)$this->params['model']->author_id;

        parent::createBlock();
    }

    public function getExist()
    {
        return $this->content !== null;
    }

    public function canBeCached()
    {
        return ($this->getContent()->gallery !== null) ? false : true;
    }
}