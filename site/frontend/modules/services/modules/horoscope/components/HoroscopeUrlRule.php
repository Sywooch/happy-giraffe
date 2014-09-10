<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HoroscopeUrlRule
 *
 * @author Кирилл
 */
class HoroscopeUrlRule extends \CBaseUrlRule
{

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if(strpos($route, 'services/horoscope/default') === 0 && empty($params))
        {
            return 'horoscope/';
        }
        elseif (strpos($route, 'services/horoscope/default') === 0)
        {
            $url = 'horoscope/';
            if ($params['alias'] && $params['alias'] != 'today')
                $url.=$params['alias'] . '/';
            if ($params['period'] && $params['period'] != 'day')
                $url.=$params['period'] . '/';
            if ($params['zodiac'])
                $url.=$params['zodiac'] . '/';
            if ($params['date'] && !$params['alias'])
                switch ($params['period'])
                {
                    case 'day':
                        $url.=date('Y-m-d', $params['date']) . '/';
                        break;
                    case 'month':
                        $url.=date('Y-m', $params['date']) . '/';
                        break;
                    case 'year':
                        $url.=date('Y', $params['date']) . '/';
                        break;
                }
            return $url;
        }
        return false;
    }

    public function parseUrl($manager, $request, $path, $rawPathInfo)
    {
        if (strpos($path, 'horoscope/') === 0 || $path == 'horoscope')
        {
            $path = explode('/', $path);

            if (count($path) == 1)
            {
                // это индекс - список на сегодня
                // Выставим дефолтные параметры
                $_GET = array(
                    'zodiac' => false,
                    'period' => 'day',
                    'date' => time(),
                    'alias' => 'today',
                );
                return 'services/horoscope/default/list';
            }
            elseif (count($path) == 2 && in_array($path[1], array('month', 'year')))
            {
                // это список на текущий месяц/год
                $_GET = array(
                    'zodiac' => false,
                    'period' => $path[1],
                    'date' => time(),
                    'alias' => false,
                );
                return 'services/horoscope/default/list';
            }
            elseif (count($path) == 2 && in_array($path[1], array('tomorrow', 'yesterday')))
            {
                // это просмотр списка на завтра
                $_GET = array(
                    'zodiac' => false,
                    'period' => 'day',
                    'date' => strtotime('+1 day'),
                    'alias' => $path[1],
                );
                return 'services/horoscope/default/list';
            }
            elseif (count($path) == 2)
            {
                // это просмотр гороскопа на сегодня
                $_GET = array(
                    'zodiac' => $path[1],
                    'period' => 'day',
                    'date' => time(),
                    'alias' => 'today',
                );
                return 'services/horoscope/default/view';
            }
            elseif (count($path) == 3 && in_array($path[1], array('month', 'year')))
            {
                // это просмотр гороскопа на текущий месяц/год
                $_GET = array(
                    'zodiac' => $path[2],
                    'period' => $path[1],
                    'date' => time(),
                    'alias' => 'today',
                );
                return 'services/horoscope/default/view';
            }
            elseif (count($path) == 3 && in_array($path[1], array('tomorrow', 'yesterday')))
            {
                // это просмотр гороскопа на завтра/вчера
                $_GET = array(
                    'zodiac' => $path[2],
                    'period' => 'day',
                    'date' => strtotime(($path[1] == 'tomorrow' ? '+1' : '-1') . ' day'),
                    'alias' => $path[1],
                );
                return 'services/horoscope/default/view';
            }
            elseif (count($path) == 3 && preg_match('~^(\d\d\d\d)-(\d\d)-(\d\d)$~', $path[2], $m) && checkdate($m[2], $m[3], $m[1]))
            {
                // это просмотр гороскопа на день
                $_GET = array(
                    'zodiac' => $path[1],
                    'period' => 'day',
                    'date' => mktime(0, 0, 0, $m[2], $m[3], $m[1]),
                    'alias' => false,
                );
                return 'services/horoscope/default/view';
            }
            elseif (count($path) == 4 && in_array($path[1], array('month', 'year')))
            {
                $date = explode('-', $path[3]);
                if ($path[1] == 'month' && count($date) == 2 && checkdate($date[1], 1, $date[0]))
                {
                    $date = mktime(0, 0, 0, $date[1], 1, $date[0]);
                }
                elseif ($path[1] == 'year' && count($date) == 1 && checkdate(1, 1, $date[0]))
                {
                    $date = mktime(0, 0, 0, 1, 1, $date[0]);
                }
                else
                {
                    return false;
                }
                // это просмотр гороскопа на месяц/год
                $_GET = array(
                    'zodiac' => $path[2],
                    'period' => $path[1],
                    'date' => $date,
                    'alias' => false,
                );
                return 'services/horoscope/default/view';
            }
        }

        return false;
    }

}

?>
