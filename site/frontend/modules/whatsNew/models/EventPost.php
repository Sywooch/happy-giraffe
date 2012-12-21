<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/29/12
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */
class EventPost extends Event
{
    /**
     * @var CommunityContent
     */
    public $post;
    public $comment;

    public function setSpecificValues()
    {
        $this->post = $this->getPost();
        $this->comment = $this->getComment();
    }

    public function getPost()
    {
        $criteria = new CDbCriteria(array(
            'scopes' => array('full'),
            'with' => array(
                'gallery' => array(
                    'with' => array(
                        'items',
                    ),
                ),
                'commentsCount'
            ),
        ));

        return CommunityContent::model()->findByPk($this->id, $criteria);
    }

    public function getComment()
    {
        $params = array(':entity_id' => $this->id);
        if ($this->post->getIsFromBlog())
            $params[':entity']='BlogContent';
        else
            $params[':entity']='CommunityContent';

        $criteria = new CDbCriteria(array(
            'condition' => 'entity = :entity AND entity_id = :entity_id',
            'params' => $params,
            'order' => 'created DESC',
            'with'=>array('author'=>array('select'=>array('id', 'first_name', 'last_name', 'avatar_id', 'deleted')))
        ));

        return Comment::model()->find($criteria);
    }
}
