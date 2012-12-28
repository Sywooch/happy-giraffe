<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:42 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventService extends FriendEvent
{
    public $type = FriendEvent::TYPE_SERVICE_USED;
    public $service_id;

    private $_service;

    public function init()
    {
        $this->_service = $this->_getService();
    }

    public function getService()
    {
        return $this->_service;
    }

    public function setService($service)
    {
        $this->_service = $service;
    }

    public function _getService()
    {
        return Service::model()->findByPk($this->service_id, array(
            'with' => 'photo',
        ));
    }

    public function getLabel()
    {
        return (($this->user->gender) ? 'Воспользовался' : 'Воспользовалась') . ' сервисом';
    }

    public function createBlock()
    {
        $this->service_id = (int) $this->params['service_id'];
        $this->user_id = (int) $this->params['user_id'];

        parent::createBlock();
    }

    public function updateBlock()
    {
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
                'service_id' => array(
                    'equals' => (int) $this->params['service_id'],
                ),
                'type' => array(
                    'equals' => $this->type,
                ),
            ),
        ));

        return FriendEvent::model($this->type)->find($criteria);
    }

    public function getExist()
    {
        return $this->service !== null && $this->service->photo !== null;
    }

    public function canBeCached()
    {
        return true;
    }
}
