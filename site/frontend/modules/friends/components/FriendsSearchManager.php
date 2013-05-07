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
    const FRIENDS_PER_PAGE = 15;

    public static function getDataProvider($userId, $params)
    {
        return new CActiveDataProvider('User', array(
            'criteria' => self::getCriteria($userId, $params),
            'pagination' => array(
                'pageSize' => self::FRIENDS_PER_PAGE,
            ),
        ));
    }

    public static function find($userId, $params, $offset)
    {
        $criteria = self::getCriteria($userId, $params);
        $criteria->limit = self::FRIENDS_PER_PAGE;
        $criteria->offset = $offset;

        return User::model()->findAll($criteria);
    }

    protected static function getCriteria($userId, $params)
    {
        $criteria = self::getDefaultCriteria($userId);

        if (isset($params['query']))
            $criteria->mergeWith(self::getQueryCriteria($params['query']));

        if (isset($params['gender']))
            $criteria->compare('t.gender', $params['gender']);

        if (isset($params['countryId']))
            $criteria->compare('address.country_id', $params['countryId']);

        if (isset($params['regionId']))
            $criteria->compare('address.region_id', $params['regionId']);

        if  (isset($params['ageMin'])) {
            $criteria->having = (empty($criteria->having)) ? 'age >= :ageMin' : ' AND age => :ageMin';
            $criteria->params[':ageMin'] = $params['ageMin'];
        }

        if  (isset($params['ageMax'])) {
            $criteria->having .= (empty($criteria->having)) ? 'age <= :ageMax' : ' AND age <= :ageMax';
            $criteria->params[':ageMax'] = $params['ageMax'];
        }

        if (isset($params['childrenType'])) {
            switch ($params['childrenType']) {
                case 1:
                    $criteria->join .= 'LEFT OUTER JOIN user__users_babies b ON b.parent_id = t.id AND type = 1 AND ROUND(DATEDIFF(CURDATE(), DATE_ADD(b.birthday, INTERVAL -9 MONTH))/7) >= :pregnancyWeekMin AND ROUND(DATEDIFF(CURDATE(), DATE_ADD(b.birthday, INTERVAL -9 MONTH))/7) <= :pregnancyWeekMax';
                    $criteria->addCondition('b.id IS NOT NULL');
                    $criteria->params[':pregnancyWeekMin'] = $params['pregnancyWeekMin'];
                    $criteria->params[':pregnancyWeekMax'] = $params['pregnancyWeekMax'];
                    break;
                case 2:
                    $criteria->join .= 'LEFT OUTER JOIN user__users_babies b ON b.parent_id = t.id AND type IS NULL AND YEAR(CURDATE()) - YEAR(b.birthday) >= :childAgeMin AND YEAR(CURDATE()) - YEAR(b.birthday) <= :childAgeMax';
                    $criteria->addCondition('b.id IS NOT NULL');
                    $criteria->params[':childAgeMin'] = $params['childAgeMin'];
                    $criteria->params[':childAgeMax'] = $params['childAgeMax'];
                    break;
                case 3:
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = ', COUNT(b.id) as childrenCount';
                    $criteria2->join = 'LEFT OUTER JOIN user__users_babies b ON b.parent_id = t.id AND type IS NULL';
                    $criteria2->having = 'childrenCount >= 3';
                    $criteria2->group = 't.id';
                    $criteria->mergeWith($criteria2);
            }
        }

        if (isset($params['relationshipStatus']))
            $criteria->compare('t.relationship_status', $params['relationshipStatus']);

        return $criteria;
    }

    protected static function getDefaultCriteria($userId)
    {
        return new CDbCriteria(array(
            'select' => 't.*, YEAR(CURDATE()) - YEAR(t.birthday) AS age',
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
            'with' => array(
                'avatar',
                'babies',
                'address' => array(
                    'with' => array(
                        'country',
                        'region',
                        'city',
                    ),
                ),
                'partner',
            ),
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
