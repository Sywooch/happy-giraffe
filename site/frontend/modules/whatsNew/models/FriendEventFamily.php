<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:42 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventFamily extends FriendEvent
{
    public $type = FriendEvent::TYPE_FAMILY_ADDED;
    public $partner_id;
    public $babies_ids = array();

    private $_partner;
    private $_babies;

    public function init()
    {
        $this->_partner = $this->_getPartner();
        $this->_babies = $this->_getBabies();
    }

    public function getPartner()
    {
        return $this->_partner;
    }

    public function setPartner($partner)
    {
        $this->_partner = $partner;
    }

    private function _getPartner()
    {
        return UserPartner::model()->findByPk($this->partner_id);
    }

    public function getBabies()
    {
        return $this->_babies;
    }

    public function setBabies($babies)
    {
        $this->_babies = $babies;
    }

    private function _getBabies()
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('t.id', $this->babies_ids);

        return Baby::model()->findAll($criteria);
    }

    public function getLabel()
    {
        return HDate::simpleVerb('Добавил', $this->user->gender) . ' семью';
    }

    public function createBlock()
    {
        if ($this->params['entity'] == 'UserPartner')
            $this->partner_id = $this->params['entity_id'];
        else
            $this->babies_ids[] = $this->params['entity_id'];
        $this->user_id = (int) $this->params['user_id'];

        parent::createBlock();
    }

    public function updateBlock($new)
    {
        if ($new->params['entity'] == 'UserPartner')
            $this->partner_id = $new->params['entity_id'];
        else
            $this->babies_ids[] = $new->params['entity_id'];
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
        return ! empty($this->babies) || $this->partner !== null;
    }

    public function canBeCached()
    {
        return true;
    }
}
