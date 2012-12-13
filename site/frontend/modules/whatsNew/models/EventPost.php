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
            ),
        ));

        return CommunityContent::model()->findByPk($this->id, $criteria);
    }

    public function getComment()
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'entity = :entity AND entity_id = :entity_id',
            'params' => array(':entity_id' => $this->id, ':entity' => 'CommunityContent'),
            'order' => 'created DESC',
        ));

        return Comment::model()->find($criteria);
    }
}
