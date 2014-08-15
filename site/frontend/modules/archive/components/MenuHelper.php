<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/08/14
 * Time: 15:39
 */

namespace site\frontend\modules\archive\components;


class MenuHelper
{
    private static $_months;
    private static $_days;

    public static function isActive($year, $month, $day)
    {
        $d1 = strtotime(implode('-', array($year, $month, $day)));
        return $d1 < time() && $d1 >= strtotime('2011-11-04');
    }

    public static function isActiveMonth($year, $month)
    {
        if (self::$_months === null) {
            $sql = <<<SQL
    SELECT DISTINCT * FROM (
    SELECT DISTINCT MONTH(created)
    FROM community__contents
    WHERE YEAR(created) = :year AND removed = 0 AND type_id != 5
    UNION
    SELECT DISTINCT MONTH(created)
    FROM cook__recipes
    WHERE YEAR(created) = :year AND removed = 0
    ) src;
SQL;
            self::$_months = \Yii::app()->db->createCommand($sql)->queryColumn(array(
                ':year' => $year,
            ));
        }
        return in_array($month, self::$_months);
    }

    public static function isActiveDay($year, $month, $day)
    {
        if (self::$_days === null) {
            $sql = <<<SQL
SELECT DISTINCT * FROM (
    SELECT DISTINCT DAY(created)
    FROM community__contents
    WHERE YEAR(created) = :year AND MONTH(created) = :month AND removed = 0 AND type_id != 5
    UNION
    SELECT DISTINCT DAY(created)
    FROM cook__recipes
    WHERE YEAR(created) = :year AND MONTH(created) = :month AND removed = 0
) src;
SQL;
            self::$_days = \Yii::app()->db->createCommand($sql)->queryColumn(array(
                ':year' => $year,
                ':month' => $month,
            ));
        }
        return in_array($day, self::$_days);
    }
} 