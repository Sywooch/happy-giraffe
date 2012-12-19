<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/14/12
 * Time: 2:48 PM
 * To change this template use File | Settings | File Templates.
 */
class FindFriendsManager
{
    const BY_ONLINE = 0;
    const BY_REGION = 1;
    const BY_INTERESTS = 2;
    const BY_STATUS = 3;

    public static function getDataProvider($type, $query)
    {
        $criteria = self::getDefaultCriteria($query);
        $criteria->mergeWith(self::getCriteriaByType($type));

        return new CActiveDataProvider('User', array(
            'criteria' => $criteria,
        ));
    }

    public static function getCriteriaByType($type)
    {
        switch ($type) {
            case self::BY_ONLINE:
                $data = array(
                    'condition' => 'online = 1 AND score.full != 0',
                    'with' => array(
                        'score',
                    ),
                    'order' => 'score.scores DESC',
                );
                break;
            case self::BY_REGION:
                $data = array(
                    'select' => 't.*, address.city_id = :city_id AS sameCity, address.city_id = :center_id as sameCenter',
                    'condition' => 'address.region_id = :region_id',
                    'with' => array(
                        'address',
                    ),
                    'order' => 'sameCity DESC, sameCenter DESC',
                    'params' => array(
                        ':region_id' => Yii::app()->user->model->address->region_id,
                        ':center_id' => Yii::app()->user->model->address->region->center_id,
                        ':city_id' => Yii::app()->user->model->address->city_id,
                    ),
                );
                break;
            case self::BY_INTERESTS:
                $data = array(
                    'select' => 't.*, COUNT(i.id) AS interestsCount',
                    'with' => array(
                        'interests',
                    ),
                    'join' => '
                        LEFT JOIN interest__users_interests ui ON t.id = ui.user_id
                        LEFT JOIN interest__interests i ON ui.interest_id = i.id
                        INNER JOIN interest__users_interests ui2 ON ui2.interest_id = i.id AND ui2.user_id = :user_id
                    ',
                    'group' => 't.id',
                    'order' => 'interestsCount DESC',
                );
                break;
            default:
                $data = array();
        }

        return new CDbCriteria($data);
    }

    public static function getDefaultCriteria($query)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 't.deleted = 0 AND t.blocked = 0 AND t.id != :hg AND t.id != :user_id AND t.id NOT IN (
                SELECT user1_id FROM friends WHERE user2_id = :user_id
                UNION
                SELECT user2_id FROM friends WHERE user1_id = :user_id
            )',
            'params' => array(
                ':hg' => User::HAPPY_GIRAFFE,
                ':user_id' => Yii::app()->user->id,
            ),
            'with' => array(
                'avatar',
            ),
        ));

        if ($query !== null) {
            $criteria->addCondition('first_name LIKE :query OR last_name LIKE :query');
            $criteria->params[':query'] = $query;
        }

        return $criteria;
    }
}
