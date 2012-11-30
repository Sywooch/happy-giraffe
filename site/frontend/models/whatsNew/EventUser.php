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
            ),
            'limit' => 6,
            'order' => 't.id DESC',
        ));

        return User::model()->findAll($criteria);
    }
}
