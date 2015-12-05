<?php
/**
 * @author Никита
 * @date 03/12/15
 */

namespace site\frontend\modules\posts\modules\contractubex\widgets\mainPosts;




use site\frontend\modules\posts\modules\contractubex\widgets\SingleWidget;

class MainPostWidget extends SingleWidget
{
    private $_commentsWidget;
    private $_commentators;

    public function getCommentators($n = 5)
    {
        if (! $this->_commentators) {
            $dp = $this->getCommentsWidget()->getDataProvider();
            $dp->getData();
            $dp->model->resetScope();
            $users = array();
            foreach ($dp->data as $comment) {
                if ($comment->author->avatarUrl) {
                    $users[$comment->author_id] = $comment->author;
                    if (count($users) == $n) {
                        break;
                    }
                }
            }
            $this->_commentators = $users;
        }
        return $this->_commentators;
    }

    public function getCommentsCount()
    {
        return $this->getCommentsWidget()->getCount();
    }

    protected function getCommentsWidget()
    {
        if (! $this->_commentsWidget) {
            $this->_commentsWidget = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
                /** @todo Исправить класс при конвертации */
                'entity' => $this->model->originService == 'oldBlog' ? 'BlogContent' : $this->model->originEntity,
                'entity_id' => $this->model->originEntityId,
            )));
        }
        return $this->_commentsWidget;
    }
}