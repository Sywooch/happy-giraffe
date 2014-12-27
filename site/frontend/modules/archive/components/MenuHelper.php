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

    /**
     *
     * @var array Список активных месяцев в выбранном году
     */
    private static $_months;

    /**
     *
     * @var array Список активных дней в выбранном году 
     */
    private static $_days;

    public static function isActive($year, $month, $day)
    {
        $d1 = strtotime(implode('-', array($year, $month, $day)));
        return $d1 < time() && $d1 >= strtotime('2011-11-04');
    }

    public static function isActiveMonth($year, $month)
    {
        if (self::$_months === null) {
            self::$_months = \site\frontend\modules\archive\models\Content::model()->getMonths($year);
        }
        return in_array($month, self::$_months);
    }

    public static function isActiveDay($year, $month, $day)
    {
        if (self::$_days === null) {
            self::$_days = \site\frontend\modules\archive\models\Content::model()->getDays($year, $month);
        }
        return in_array($day, self::$_days);
    }

}
