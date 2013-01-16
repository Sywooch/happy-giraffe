<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/29/12
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */
class EventUser extends Event
{
    public $users;

    protected $clusterable = true;

    public function setSpecificValues()
    {
        $this->users = $this->getUsers();
    }

    public function getUsers()
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'avatar',
                'score',
            ),
            'limit' => 6,
            'order' => 'last_updated DESC',
            'condition' => 'full != 0',
        ));

        return User::model()->findAll($criteria);
    }

    public function canBeCached()
    {
        return false;
    }
}
