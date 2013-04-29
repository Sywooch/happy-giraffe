<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/27/13
 * Time: 4:01 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendsManager
{
    const FRIENDS_PER_PAGE = 15;

    public static function getFriends($userId, $online, $listId, $query, $offset)
    {
        $criteria = self::getCriteria($userId, $online, $listId, $query);
        $criteria->limit = ($offset == 0) ? self::FRIENDS_PER_PAGE - 1 : self::FRIENDS_PER_PAGE;
        $criteria->offset = $offset;
        $criteria->order = 'friend.online DESC';

        return Friend::model()->findAll($criteria);
    }

    public static function getFriendsCount($userId, $online, $listId, $query, $offset)
    {
        $criteria = self::getCriteria($userId, $online, $listId, $query);

        return Friend::model()->count($criteria);
    }

    protected static function getCriteria($userId, $online, $listId, $query)
    {
        $criteria = new CDbCriteria(array(
            'with' => 'friend',
        ));

        $criteria->compare('t.user_id', $userId);

        if ($online)
            $criteria->compare('friend.online', '1');

        if ($listId)
            $criteria->compare('t.list_id', $listId);

        if ($query) {
            $sCriteria = new CDbCriteria();
            $sCriteria->addSearchCondition('first_name', $query);
            $sCriteria->addSearchCondition('last_name', $query, true, 'OR');
            $sCriteria->addSearchCondition(new CDbExpression('CONCAT_WS(\' \', first_name, last_name)'), $query, true, 'OR');
            $criteria->mergeWith($sCriteria);
        }

        return $criteria;
    }

    public static function getLists($userId)
    {
        return FriendList::model()->with('friendsCount')->findAllByAttributes(array('user_id' => $userId));
    }
}
