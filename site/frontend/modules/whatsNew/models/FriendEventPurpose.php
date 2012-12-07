<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:34 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventPurpose extends FriendEvent
{
    public $type = FriendEvent::TYPE_PURPOSE_UPDATED;
    public $purpose_id;

    private $_purpose;

    public function init()
    {
        $this->_purpose = $this->_getPurpose();
    }

    public function getPurpose()
    {
        return $this->_purpose;
    }

    public function setPurpose($purpose)
    {
        $this->_purpose = $purpose;
    }

    private function _getPurpose()
    {
        return UserPurpose::model()->findByPk($this->purpose_id);
    }

    public function createBlock()
    {
        $this->purpose_id = (int) $this->params['model']->id;
        $this->user_id = (int) $this->params['model']->user_id;

        parent::createBlock();
    }

    public function getLabel()
    {
        return HDate::simpleVerb('Изменил', $this->user->gender) . ' цель';
    }
}
