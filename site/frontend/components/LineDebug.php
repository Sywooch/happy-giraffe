<?php

namespace site\frontend\components;

/**
 * инструмент отладки
 * вывод отладочной информации с лимитами памяти и прошешдшим времени
 * @author crocodile
 */
class LineDebug
{

    private static $startTime = null;
    private static $lastTime = null;

    /**
     * инициализация начала отладки, запоминает стартовое время
     */
    public static function init()
    {
        self::$startTime = microtime(true);
        self::$lastTime = microtime(true);
    }

    /**
     * выводит строку отладки
     */
    public static function printDebugLine($line = __LINE__)
    {
        $debug = debug_backtrace(null, 1);

        print "debug: " . basename($debug[0]['file']) . ":" . $debug[0]['line']
                . "; memory peak: " . self::getMemoryPeak()
                . "; memory used: " . self::getMemoryCurent()
                . "; last time " . self::getLastTime()
                . "; work time " . self::getWokTime() . "\r\n";
    }

    public static function getWokTime()
    {
        $sec = microtime(1) - self::$startTime;
        $hour = floor($sec / 3600);
        if ($hour > 0)
        {
            $sec -= $hour * 3600;
        }
        $min = floor($sec / 60);
        if ($min > 0)
        {
            $sec -= $min * 60;
        }

        return ($hour > 0 ? ($hour . 'h ') : '')
                . ($min > 0 ? ($min . 'm ') : '')
                . round($sec, 4) . 's';
    }

    public static function getLastTime()
    {
        $r = round(microtime(1) - self::$lastTime, 4) . 's';
        self::$lastTime = microtime(1);
        return $r;
    }

    public static function printSQLLog()
    {
        $lg = \YiiBase::getLogger();
        $list = $lg->getLogs('profile', 'system.db.CDbCommand.query');
        $lastTime = $list[0][3];
        foreach ($list AS $row)
        {
            print "query:" . wordwrap($row[0], 250) . "\r\n";
            print "time: " . round($row[3] - $lastTime, 5) . "\r\n";
            $lastTime = $row[3];
        }
        exit();
        var_dump($list);
    }

    private static function memoryFormat($val)
    {
        $c = 0;
        while ($val > 1024)
        {
            $val /= 1024;
            $c++;
        }
        $val = round($val, 4);
        switch ($c)
        {
            case 0:
                return $val . 'b';
            case 1:
                return $val . 'Kb';
            case 2:
                return $val . 'Mb';
            case 3:
                return $val . 'Gb';
            case 4:
                return $val . 'Tb';
            default :
                return 'to lage';
        }
    }

    /**
     * возвращает пиковое использование памяти
     * @return string
     */
    public static function getMemoryPeak()
    {
        return self::memoryFormat(memory_get_peak_usage());
    }

    /**
     * возвращает текущее использование памяти
     * @return string
     */
    public static function getMemoryCurent()
    {
        return self::memoryFormat(memory_get_usage());
    }

}
