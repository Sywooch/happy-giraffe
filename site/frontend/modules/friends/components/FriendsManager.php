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

    public static function getFriends($userId, $online, $new, $listId, $query, $offset)
    {
        $criteria = self::getCriteria($userId, $online, $new, $listId, $query);
        $criteria->limit = ($offset == 0) ? self::FRIENDS_PER_PAGE - 1 : self::FRIENDS_PER_PAGE;
        $criteria->offset = $offset;

        return Friend::model()->findAll($criteria);
    }

    public static function getFriendsCount($userId, $online, $new, $listId, $query, $offset)
    {
        $criteria = self::getCriteria($userId, $online, $new, $listId, $query);

        return Friend::model()->count($criteria);
    }

    protected static function getCriteria($userId, $online, $new, $listId, $query)
    {
        $criteria = new CDbCriteria(array(
            'select' => '*, COUNT(p.id) AS pCount, 0 AS bCount',
            'with' => 'friend',
            'join' => '
                LEFT OUTER JOIN visits va ON va.user_id = t.user_id AND va.url = CONCAT(\'/user/\', t.friend_id, \'/albums/\')
                LEFT OUTER JOIN album__photos p ON p.author_id = t.friend_id AND (va.id IS NULL OR p.created > va.last_visit)
            ',
            'order' => 'friend.online DESC, t.id DESC',
            'group' => 't.friend_id',
        ));

        $criteria->compare('t.user_id', $userId);

        if ($online)
            $criteria->compare('friend.online', '1');

        if ($listId)
            $criteria->compare('t.list_id', $listId);

        if ($new)
            $criteria->addCondition('t.created >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)');

        if ($query) {
            $sCriteria = new CDbCriteria();
            $sCriteria->addSearchCondition('first_name', $query);
            $sCriteria->addSearchCondition('last_name', $query, true, 'OR');
            $sCriteria->addSearchCondition(new CDbExpression('CONCAT_WS(\' \', first_name, last_name)'), $query, true, 'OR');
            $sCriteria->addSearchCondition(new CDbExpression('CONCAT_WS(\' \', last_name, first_name)'), $query, true, 'OR');
            $criteria->mergeWith($sCriteria);
        }

        return $criteria;
    }

    public static function getLists($userId)
    {
        return FriendList::model()->with('friendsCount')->findAllByAttributes(array('user_id' => $userId));
    }
}
