<?php

class UserSignalHistory extends EMongoDocument
{
    public $user_id;
    public $date;
    public $numberTaskSuccess = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'userSignalsHistory';
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        if (!empty($this->user_id))
            return User::getUserById($this->user_id);
        return null;
    }

}
