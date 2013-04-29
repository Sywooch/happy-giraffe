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
    public static function search($userId, $params)
    {
        $criteria = self::getDefaultCriteria($userId);

        if (isset($params['query']))
            $criteria->mergeWith(self::getQueryCriteria($params['query']));

        if (isset($params['gender']))
            $criteria->compare('t.gender', $params['gender']);

        if (isset($params['countryId']) || isset($params['regionId']))
            $criteria->join .= 'LEFT OUTER JOIN geo__user_address address ON address.user_id = t.id';

        if (isset($params['countryId']))
            $criteria->compare('address.country_id', $params['countryId']);

        if (isset($params['regionId']))
            $criteria->compare('address.region_id', $params['regionId']);

        if  (isset($params['ageMin']) !== false)
            $criteria->compare('age', '>=' . $params['ageMin']);

        if  (isset($params['ageMax']))
            $criteria->compare('age', '<=' . $params['ageMax']);

        if (isset($params['relationshipStatus']))
            $criteria->compare('t.relationship_status', $params['relationshipStatus']);

        return new CActiveDataProvider('User', array(
            'criteria' => $criteria,
        ));
    }

    protected static function getDefaultCriteria($userId)
    {
        return new CDbCriteria(array(
            'select' => 't.*, YEAR(CURDATE()) - YEAR(birthday) AS age',
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

    protected static function getQueryCriteria($query)
    {
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('first_name', $query);
        $criteria->addSearchCondition('last_name', $query, true, 'OR');
        $criteria->addSearchCondition(new CDbExpression('CONCAT_WS(\' \', first_name, last_name)'), $query, true, 'OR');
        return $criteria;
    }
}
