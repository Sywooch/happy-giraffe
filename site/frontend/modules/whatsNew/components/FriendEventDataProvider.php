<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 3:15 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventDataProvider extends EMongoDocumentDataProvider
{
    public function fetchData()
    {
        $data = parent::fetchData();

        $usersIds = array();
        foreach ($data as $k => $v)
            $usersIds[] = $v->user_id;

        $criteria = FriendEvent::getUserCriteria();
        $criteria->addInCondition('t.id', $usersIds);
        $criteria->with = array(
            'avatar',
        );
        $users = User::model()->findAll($criteria);

        foreach ($data as $k => $v) {
            $v->user = $users[$v->user_id];
            if (! $v->exist)
                unset($data[$k]);
        }

        $data = array_values($data);

        return $data;
    }
}
