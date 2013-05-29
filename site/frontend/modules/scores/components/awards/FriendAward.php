<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 */
class FriendAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";
        $award_id = 30;

        $criteria = self::getSimpleCriteria();

        $models = array(1);
        $users = array();
        $i = 0;
        while (!empty($models)) {
            $criteria->offset = 100 * $i;
            $models = Friend::model()->findAll($criteria);

            foreach ($models as $model) {
                $users = self::addUser($users, $model->user1_id);
                $users = self::addUser($users, $model->user2_id);
            }
            $i++;
        }

        $max = 0;
        foreach ($users as $count)
            if ($count > $max)
                $max = $count;

        echo "max: $max \n";
        foreach ($users as $user => $count)
            if ($count == $max) {
                self::giveAward($user, $award_id);
            }
    }

    public function getSimpleCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('t.user1_id', 't.user2_id');
        $criteria = self::addMonthCriteria($criteria);
        $criteria->limit = 100;

        return $criteria;
    }

    public static function addUser($users, $user_id)
    {
        if (!isset($users[$user_id]))
            $users[$user_id] = 0;
        $users[$user_id]++;

        return $users;
    }
}
