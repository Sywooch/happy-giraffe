<?php

/**
 * @author Emil Vililyaev
 */
class CommentLogger
{

    /**
     * @var self
     */
    static $obj;

    /**
     * @var mixed
     */
    private $_start_time;

    /**
     * @var mixed
     */
    private $_last_time;

    /**
     * @var array
     */
    private $_log = [];

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {

    }

    /**
     * @return number
     */
    private function _getCurrentTime()
    {
        return round(microtime(true) * 1000, 3);
    }

    /**
     * @return array
     */
    private function _getTime()
    {
        $currentTime = $this->_getCurrentTime();
        $difference = $currentTime - $this->_last_time;
        $this->_last_time = $currentTime;
        $date = date('j D H:i:s');

        return [
            'difference' => round($difference, 3),
            'date' => $date
        ];
    }

    /**
     * write logs to file
     */
    private function _writeToFile()
    {
        $fh = fopen($dir = Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'log.txt', 'a');
        fwrite($fh, implode("\n", $this->_log) . "\n\n\n");
        $this->_log = [];
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Call this method to get singleton
     *
     * @return self
     */
    public static function model()
    {
        if (self::$obj == null)
            self::$obj = new self();
        return self::$obj;
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * set timer and set start handler
     */
    public function startTimer()
    {
        $this->_start_time = $this->_getCurrentTime();
        $this->_last_time = $this->_start_time;
        $this->addToLog('Start action', '--------------------------------');
    }

    /**
     * @param string $title
     * @param string $message
     */
    public function addToLog($title, $message, $level = null)
    {
        $arrTime = $this->_getTime();
        $prefix = is_null($level) ? '' : "\t";
        $this->_log[] = $prefix . $arrTime['date'] . ' [+' . $arrTime['difference'] . ']' . ' [' . $title . '] -> ' . $message;
    }

    /**
     * set final handker and write to file
     */
    public function push()
    {
        $this->addToLog('Total time: ', round($this->_getCurrentTime() - $this->_start_time, 3) . ' ms');
        $this->addToLog('Stop action', '--------------------------------');
        $this->_writeToFile();
        $this->_last_time = 0;
        $this->_start_time = 0;
    }
}