<?php

/**
 * Helper для дат
 *
 * @package helpers
 * @author Alex Kireev
 */
class HDate
{
    public static function ruMonths()
    {
        return array(
            1 => "Январь",
            2 => "Февраль",
            3 => "Март",
            4 => "Апрель",
            5 => "Май",
            6 => "Июнь",
            7 => "Июль",
            8 => "Август",
            9 => "Сентябрь",
            10 => "Октябрь",
            11 => "Ноябрь",
            12 => "Декабрь");
    }

    public static function ruShortMonths()
    {
        return array(
            1 => "Янв",
            2 => "Фев",
            3 => "Мар",
            4 => "Апр",
            5 => "Май",
            6 => "Июн",
            7 => "Июл",
            8 => "Авг",
            9 => "Сен",
            10 => "Окт",
            11 => "Ноя",
            12 => "Дек");
    }

    public static function ruMonth($num)
    {
        switch ($num) {
            case 1 :
                return "Январь";
            case 2  :
                return "Февраль";
            case 3  :
                return "Март";
            case 4  :
                return "Апрель";
            case 5  :
                return "Май";
            case 6  :
                return "Июнь";
            case 7  :
                return "Июль";
            case 8  :
                return "Август";
            case 9  :
                return "Сентябрь";
            case 10  :
                return "Октябрь";
            case 11  :
                return "Ноябрь";
            case 12  :
                return "Декабрь";
        }
    }

    public static function ruMonthShort($num)
    {
        switch ($num) {
            case 1 :
                return "янв";
            case 2  :
                return "фев";
            case 3  :
                return "мар";
            case 4  :
                return "апр";
            case 5  :
                return "май";
            case 6  :
                return "июн";
            case 7  :
                return "июл";
            case 8  :
                return "авг";
            case 9  :
                return "сен";
            case 10  :
                return "окт";
            case 11  :
                return "ноя";
            case 12  :
                return "дек";
        }
    }

    public static function Days()
    {
        $result = array();
        $first = 1;
        while ($first < 32) {
            $result [$first] = $first;
            $first++;
        }

        return $result;
    }

    public static function Range($first, $second)
    {
        $result = array();

        if ($first <= $second) {
            while ($first < $second + 1) {
                $result [$first] = $first;
                $first++;
            }
        } else {
            while ($first > $second + 1) {
                $result [$first] = $first;
                $first--;
            }
        }

        return $result;
    }

    /**
     * @param $timespan int
     * @return string
     */
    public static function russian_date($timespan)
    {
        $date = explode(".", date("j.m.Y", $timespan));
        switch ($date[1]) {
            case 1:
                $m = 'янв';
                break;
            case 2:
                $m = 'фев';
                break;
            case 3:
                $m = 'мар';
                break;
            case 4:
                $m = 'апр';
                break;
            case 5:
                $m = 'май';
                break;
            case 6:
                $m = 'июн';
                break;
            case 7:
                $m = 'июл';
                break;
            case 8:
                $m = 'авг';
                break;
            case 9:
                $m = 'сен';
                break;
            case 10:
                $m = 'окт';
                break;
            case 11:
                $m = 'ноя';
                break;
            case 12:
                $m = 'дек';
                break;
        }
        return array('day' => $date[0],
            'month' => $m,
            'year' => $date[2]);
    }

    /**
     * Формы слов по порядку в массиве (1: день, 2-4:дня, 5-10:дней)
     *
     * @static
     * @param $words
     * @param $number string
     */
    public static function GenerateNoun($words, $number)
    {
        switch ($number) {
            case 11:
                return $words[2];
            case 12:
                return $words[2];
            case 13:
                return $words[2];
            case 14:
                return $words[2];
        }
        if (strstr($number, '.') || strstr($number, ','))
            return $words[2];

        $last_symbol = substr($number, -1);
        switch ($last_symbol) {
            case 1:
                return $words[0];
            case 2:
                return $words[1];
            case 3:
                return $words[1];
            case 4:
                return $words[1];
            case 5:
                return $words[2];
            case 6:
                return $words[2];
            case 7:
                return $words[2];
            case 8:
                return $words[2];
            case 9:
                return $words[2];
            case 0:
                return $words[2];
        }
    }
}
