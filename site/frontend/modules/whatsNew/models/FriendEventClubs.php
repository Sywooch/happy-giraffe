<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:41 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventClubs extends FriendEvent
{
    public $type = FriendEvent::TYPE_CLUBS_JOINED;
    public $clubs_ids = array();

    private $_clubs;

    public function init()
    {
        $this->_clubs = $this->_getClubs();
    }

    public function getClubs()
    {
        return $this->_clubs;
    }

    public function setClubs($clubs)
    {
        $this->clubs = $clubs;
    }

    private function _getClubs()
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('t.id', $this->clubs_ids);

        return Community::model()->findAll($criteria);
    }

    public function getLabel()
    {
        return HDate::simpleVerb('Вступил', $this->user->gender) . ' в клубы';
    }

    public function createBlock()
    {
        $this->clubs_ids[] = (int) $this->params['id'];
        $this->user_id = (int) $this->params['user_id'];

        parent::createBlock();
    }

    public function updateBlock($new)
    {
        $this->clubs_ids[] = (int) $new->params['id'];
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
//                'updated' => array(
//                    'greater' => time() - 60 * 30,
//                ),
            ),
        ));

        return FriendEvent::model($this->type)->find($criteria);
    }
}
