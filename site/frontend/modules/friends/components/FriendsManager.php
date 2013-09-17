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
            'select' => '*, 0 AS pCount, 0 AS bCount',
            'with' => 'friend',
            'order' => 'friend.id DESC',
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

    public static function userToJson($user, $isFriend = false)
    {
        $family = Yii::app()->controller->widget('application.modules.family.widgets.UserFamilyWidget', array('user' => $user), true);

        return array(
            'id' => $user->id,
            'online' => (bool)$user->online,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'ava' => $user->getAvatarUrl(Avatar::SIZE_LARGE),
            'age' => $user->normalizedAge,
            'location' => ($user->address->country_id !== null) ? Yii::app()->controller->renderPartial('application.modules.friends.views._location', array('data' => $user), true) : null,
            'family' => $family !== '' ? $family : null,
            'isFriend' => $isFriend
        );
    }
}
