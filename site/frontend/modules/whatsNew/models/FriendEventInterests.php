<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:42 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventInterests extends FriendEvent
{
    public $type = FriendEvent::TYPE_INTERESTS_ADDED;
    public $interests_ids = array();

    private $_interests;

    public function init()
    {
        $this->_interests = $this->_getInterests();
    }

    public function getInterests()
    {
        return $this->_interests;
    }

    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    private function _getInterests()
    {
        $criteria = new CDbCriteria(array(
            'with' => 'category',
        ));
        $criteria->addInCondition('t.id', $this->interests_ids);

        return Interest::model()->findAll($criteria);
    }

    public function getLabel()
    {
        return HDate::simpleVerb('Добавил', $this->user->gender) . ' интересы';
    }

    public function createBlock()
    {
        $this->interests_ids[] = (int) $this->params['id'];
        $this->user_id = (int) $this->params['user_id'];

        parent::createBlock();
    }

    public function updateBlock($new)
    {
        $this->interests_ids[] = (int) $new->params['id'];
        $this->updated = time();
        $this->save();
    }

    public function getStack()
    {
        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'user_id' => array(
                    'equals' => (int) $this->params['user_id'],
                ),
                'type' => array(
                    'equals' => $this->type,
                ),
                'updated' => array(
                    'greater' => time() - 60 * 60 * 24,
                ),
            ),
        ));

        return FriendEvent::model($this->type)->find($criteria);
    }

    public function getExist()
    {
        return ! empty($this->interests);
    }

    public function canBeCached()
    {
        return true;
    }
}
