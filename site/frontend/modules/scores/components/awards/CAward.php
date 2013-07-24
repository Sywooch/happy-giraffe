<?php
/**
 * Class CAward
 *
 * Распределние трофеев между пользователями. Запускается из консоли в конце недели/месяца
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
abstract class CAward
{
    const PERIOD_WEEK = 1;
    const PERIOD_MONTH = 2;

    /**
     * Выдать трофей победителю. Если трофей еще не выдан в этот день
     *
     * @param $user_id int id победителя
     * @param $award_id int id награды
     */
    protected static function giveAward($user_id, $award_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $user_id);
        $criteria->compare('award_id', $award_id);
        $criteria->compare('created', date("Y-m-d"));
        $exist = ScoreUserAward::model()->find($criteria);
        if (!$exist) {
            $award = new ScoreUserAward();
            $award->award_id = $award_id;
            $award->user_id = $user_id;
            $award->save();
            echo $user_id . "\n";
        }
    }

    /**
     * Возвращает условие ограниченя по времени
     *
     * @param int $period
     * @return string
     */
    public static function getTimeCondition($period = self::PERIOD_MONTH)
    {
        if ($period == self::PERIOD_MONTH)
            return self::getMonthCondition();
        return self::getWeekCondition();
    }

    /**
     * Возвращает условие ограничения по времени в предыдущую неделю
     *
     * @return string
     */
    protected static function getWeekCondition()
    {
        $d = new DateTime();
        $weekday = $d->format('w');
        $diff = 7 + ($weekday == 0 ? 6 : $weekday - 1); // Monday=0, Sunday=6
        $d->modify("-$diff day");

        $date1 = $d->format('Y-m-d');
        $d->modify('+6 day');
        $date2 = $d->format('Y-m-d');

        return 't.created >= "' . $date1 . ' 00:00:00" AND t.created <= "' . $date2 . ' 23:59:59"';
    }

    /**
     * Возвращает условие ограничения по времени в предыдущий месяц
     *
     * @return string
     */
    protected static function getMonthCondition()
    {
        $prev_month = strtotime("-10 days");
        $date1 = date("Y-m", $prev_month) . '-01';
        $date2 = date("Y-m", $prev_month) . '-31';

        return 't.created >= "' . $date1 . ' 00:00:00" AND t.created <= "' . $date2 . ' 23:59:59"';
    }
}
