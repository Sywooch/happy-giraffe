<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 */
abstract class CAward
{
    protected static function showMaxPostsCount($count)
    {
        echo 'max count: ' . $count . "\n";
    }

    /**
     * @param bool $week
     * @return CDbCriteria
     */
    protected static function getCriteria($week = false)
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('t.author_id', 'COUNT(t.id) AS count');
        $criteria->scopes = array('active');
        $criteria->group = 't.author_id';
        if ($week)
            $criteria = self::addWeekCriteria($criteria);
        else
            $criteria = self::addMonthCriteria($criteria);

        return $criteria;
    }

    protected static function awardByMaxCount($criteria, $max_count, $award_id, $class = 'CommunityContent')
    {
        $criteria->having = 'COUNT(t.id) = ' . $max_count;
        $models = $class::model()->findAll($criteria);

        echo "users:\n";
        foreach ($models as $model)
            self::giveAward($model->author_id, $award_id);
    }

    protected static function giveAward($user_id, $award_id)
    {
        $award = new ScoreUserAward();
        $award->award_id = $award_id;
        $award->user_id = $user_id;
        $award->save();
        echo $user_id . "\n";
    }

    protected static function addWeekCriteria($criteria)
    {
        $d = new DateTime();
        $weekday = $d->format('w');
        $diff = 7 + ($weekday == 0 ? 6 : $weekday - 1); // Monday=0, Sunday=6
        $d->modify("-$diff day");

        $date1 = $d->format('Y-m-d');
//        echo $date1 . "\n";
        $d->modify('+6 day');
        $date2 = $d->format('Y-m-d');
//        echo $date2 . "\n";

        $criteria->mergeWith(array('condition' => 't.created >= "' . $date1 . ' 00:00:00" AND t.created <= "' . $date2 . ' 23:59:59"'));

        return $criteria;
    }

    protected static function addMonthCriteria($criteria)
    {
        list($date1, $date2) = self::getMonthDates();
        $criteria->mergeWith(array('condition' => 't.created >= "' . $date1 . ' 00:00:00" AND t.created <= "' . $date2 . ' 23:59:59"'));

        return $criteria;
    }

    protected static function getMonthDates()
    {
        $current_month = date("m");
        $year = date("Y");
        if ($current_month == 1) {
            $month = 12;
            $year = date("Y") - 1;
        } else
            $month = str_pad(($current_month - 1), 2, "0", STR_PAD_LEFT);

        $date1 = $year . '-' . $month . '-' . '01';
        //echo $date1 . "\n";
        $date2 = $year . '-' . $month . '-' . date("t", strtotime('01-' . $month . $year));
        //echo $date2 . "\n";

        return array($date1, $date2);
    }

}
