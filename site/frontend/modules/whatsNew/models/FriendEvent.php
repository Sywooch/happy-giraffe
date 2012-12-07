<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/5/12
 * Time: 3:52 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEvent extends EMongoDocument
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_actions';
    }
}
