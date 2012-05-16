<?php
/**
 * Найти друзей
 *
 * Список пользователей с заполненными анкетами.
 *
 * Author: choo
 * Date: 15.05.2012
 */
class FriendsWidget extends CWidget
{
    public function run()
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.*, count(interests_interests.user_id) AS interestsCount, count(' . Baby::model()->getTableAlias() .  '.id) AS babiesCount',
            'group' => 't.id',
            'having' => 'interestsCount > 0 AND (babiesCount > 0 OR t.relationship_status IS NOT NULL)',
            'condition' => 't.avatar_id IS NOT NULL AND userAddress.country_id IS NOT NULL',
            'with' => array(
                'interests' => array(
                    'together' => true,
                ),
                'userAddress',
                'babies' => array(
                    'condition' => 'sex != 0 OR type IS NOT NULL',
                ),
            ),
            'order' => 'RAND()',
            'limit' => 2,
        ));

        if (Yii::app()->user->id) {
            $criteria->join .= ' LEFT JOIN friends ON (friends.user1_id = :me AND friends.user2_id = t.id) OR (friends.user2_id = :me AND friends.user1_id = t.id)';
            $criteria->addCondition('t.id != :me AND friends.id IS NULL');
            $criteria->params = array(':me' => Yii::app()->user->id);
        }

        $friends = User::model()->findAll($criteria);
        $this->render('FriendsWidget', compact('friends'));
    }
}
