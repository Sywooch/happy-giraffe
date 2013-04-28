<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/28/13
 * Time: 3:52 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendsSearchManager
{
    public static function search($userId)
    {
        $criteria = self::getDefaultCriteria($userId);

        return User::model()->count($criteria);
    }

    protected static function getDefaultCriteria($userId)
    {
        return new CDbCriteria(array(
            'condition' => '
                t.id != :user_id AND
                t.id != :hg AND
                t.deleted = 0 AND
                t.blocked = 0 AND
                f.id IS NULL AND
                fr.id IS NULL
            ',
            'join' => '
                LEFT OUTER JOIN friends f ON f.user_id = :user_id AND f.friend_id = t.id
                LEFT OUTER JOIN friend_requests fr ON fr.from_id = :user_id AND fr.to_id = t.id AND fr.status = \'pending\'
            ',
            'params' => array(
                ':user_id' => $userId,
                ':hg' => User::HAPPY_GIRAFFE,
            ),
        ));
    }
}
