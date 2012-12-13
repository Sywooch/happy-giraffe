<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:37 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventComment extends FriendEvent
{
    public $type = FriendEvent::TYPE_COMMENT_ADDED;
    public $comment_id;

    private $_comment;
    private $_related_model;

    public function init()
    {
        $this->comment = $this->_getComment();
        if ($this->comment !== null)
            $this->relatedModel = $this->comment->getRelatedModel();
    }

    public function getComment()
    {
        return $this->_comment;
    }

    public function setComment($comment)
    {
        $this->_comment = $comment;
    }

    public function getRelatedModel()
    {
        return $this->_related_model;
    }

    public function setRelatedModel($relatedModel)
    {
        $this->_related_model = $relatedModel;
    }

    private function _getComment()
    {
        return Comment::model()->findByPk($this->comment_id);
    }

    public function getLabel()
    {
        switch (get_class($this->relatedModel)) {
            case 'BlogContent':
                return HDate::simpleVerb('Добавил', $this->user->gender) . ' комментарий в блоге';
                break;
            case 'CommunityContent':
                return HDate::simpleVerb('Добавил', $this->user->gender) . ' комментарий в клубе';
                break;
            default:
                return HDate::simpleVerb('Добавил', $this->user->gender) . ' комментарий';
        }
    }

    public function getToString()
    {
        switch (get_class($this->relatedModel)) {
            case 'BlogContent':
            case 'CommunityContent':
                switch ($this->relatedModel->type_id) {
                    case 1:
                        return 'к записи';
                    case 2:
                        return 'к видео';
                    default:
                        return 'к посту';
                }
                break;
            default:
                return false;
        }
    }

    public function createBlock()
    {
        if (! in_array(get_class($this->params['relatedModel']), array('CommunityContent', 'BlogContent', 'CookRecipe', 'Service')))
            return false;

        $this->comment_id = (int) $this->params['model']->id;
        $this->user_id = (int) $this->params['model']->author_id;

        parent::createBlock();
    }

    public function getExist()
    {
        return $this->comment !== null && $this->relatedModel !== null;
    }
}
