<?php
/**
 * @author Никита
 * @date 30/10/14
 */

namespace site\frontend\modules\family\components;


class AgeHelper
{
    public static function getAge($birthday)
    {
        $interval = self::getIntervalFrom($birthday);
        return $interval->y;
    }

    public static function getAgeString($birthday)
    {
        $age = self::getAge($birthday);
        return $age . ' ' . \Str::GenerateNoun(array('год', 'года', 'лет'), $age);
    }

    public static function getChildAgeString($birthday)
    {
        $interval = self::getIntervalFrom($birthday);

        if ($interval->days == 0) {
            return 'Сегодня';
        }

        if ($interval->days < 7) {
            return $interval->d . ' ' . \Str::GenerateNoun(array('день', 'дня', 'дней'), $interval->d);
        }

        if ($interval->m == 0 && $interval->y == 0) {
            $weeks = floor($interval->d / 7);
            return $weeks . ' ' . \Str::GenerateNoun(array('неделя', 'недели', 'недель'), $weeks);
        }

        if ($interval->y == 0) {
            return $interval->m . ' ' . \Str::GenerateNoun(array('месяц', 'месяца', 'месяцев'), $interval->m);
        }

        if ($interval->y < 3) {
            $result =  $interval->y . ' ' . \Str::GenerateNoun(array('год', 'года', 'лет'), $interval->y);
            if ($interval->m > 0) {
                $result .= $interval->m . ' ' . \Str::GenerateNoun(array('месяц', 'месяца', 'месяцев'), $interval->m);
            }
            return $result;
        }

        return $interval->y . ' ' . \Str::GenerateNoun(array('год', 'года', 'лет'), $interval->y);
    }

    protected static function getIntervalFrom($birthday)
    {
        $date1 = new \DateTime($birthday);
        $date2 = new \DateTime(date('Y-m-d'));
        return $date1->diff($date2);
    }
} 