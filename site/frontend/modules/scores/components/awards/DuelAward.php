<?php
/**
 * Class DuelAward
 *
 * Заядлый дуэлянт
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class DuelAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";
        $award_id = ScoreAward::TYPE_DUEL;

        $criteria = self::getSimpleCriteria();

        $models = array(1);
        $users = array();
        $i = 0;
        while (!empty($models)) {
            $criteria->offset = 100 * $i;
            $models = DuelAnswer::model()->findAll($criteria);

            foreach ($models as $model) {
                $users = self::addUser($users, $model->user_id);
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
        $criteria->select = array('t.user_id');
        list($date1, $date2) = self::getMonthDates();
        $criteria->with = array(
            'question' => array(
                'condition' => 'question.ends >= "' . $date1 . ' 00:00:00" AND question.ends <= "' . $date2 . ' 23:59:59"'
            )
        );
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
