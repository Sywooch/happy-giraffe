<?php
/**
 * Author: alexk984
 * Date: 20.11.12
 */

class TimeLogger
{
    private $_start_time;
    private $_time_stamp_title;

    public function startTimer($title)
    {
        $this->_start_time = microtime(true);
        $this->_time_stamp_title = $title;
    }

    public function endTimer()
    {
        $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'log.txt', 'a');
        $long_time = 1000*(microtime(true) - $this->_start_time);
        fwrite($fh, $this->_time_stamp_title.': '. $long_time . "\n");
    }

    /**
     * Call this method to get singleton
     *
     * @return TimeLogger
     */
    public static function model()
    {
        static $inst = null;
        if ($inst == null)
            $inst = new TimeLogger();
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {

    }
}