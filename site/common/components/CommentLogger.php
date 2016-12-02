<?php

/**
 * @author Emil Vililyaev
 */
class CommentLogger
{

    /**
     * @var self
     */
    private static $obj;

    /**
     * @var mixed
     */
    private $_startTime;

    /**
     * @var mixed
     */
    private $_lastTime;

    /**
     * @var mixed
     */
    private $_maxDifferenceTime = 0;

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
        $difference = $currentTime - $this->_lastTime;
        $this->_lastTime = $currentTime;
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
        fwrite($fh, implode("\n", $this->_log) . "\n\n");
        $this->_cleanData();
    }

    /**
     * @param boolean $cleanLogArray
     */
    private function _cleanData($cleanLogArray = TRUE)
    {
        $this->_lastTime = null;
        $this->_startTime = null;
        $this->_maxDifferenceTime = 0;

        if ($cleanLogArray)
        {
            $this->_log = [];
        }
    }

    /**
     * set timer and set start handler
     */
    private function _startTimer()
    {
        $this->_startTime = $this->_getCurrentTime();
        $this->_lastTime = $this->_startTime;
        $this->addToLog('Start log', '--------------------------------');
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
     * @param string $title
     * @param string $message
     *
     * @return self
     */
    public function addToLog($title, $message, $level = null)
    {
        if (is_null($this->_startTime))
        {
            $this->_startTimer();
        }

        $arrTime = $this->_getTime();

        if ($this->_maxDifferenceTime < $arrTime['difference'])
        {
            $this->_maxDifferenceTime = $arrTime['difference'];
        }

        $prefix = is_null($level) ? '' : "\t";
        $this->_log[] = $prefix . $arrTime['date'] . ' [+' . $arrTime['difference'] . ']' . ' [' . $title . '] -> ' . $message;

        return $this;
    }

    /**
     * set final handker and write to file
     */
    public function push($bPushTotal = TRUE, $stopLogMessage = '--------------------------------')
    {
        if (empty($this->_log))
        {
            return;
        }

        if ($this->_maxDifferenceTime < 0)
        {
            $this->_cleanData();
            return;
        }

        if ($bPushTotal)
        {
            $this->addToLog('Total time: ', round($this->_getCurrentTime() - $this->_startTime, 3) . ' ms');
        }

        $this->addToLog('Stop log', $stopLogMessage);
        $this->_writeToFile();
    }

    public function __destruct()
    {
        $this->push(TRUE, 'called from destructor');
    }
}