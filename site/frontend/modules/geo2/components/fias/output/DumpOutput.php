<?php
/**
 * @author Никита
 * @date 22/02/17
 */

namespace site\frontend\modules\geo2\components\fias\output;


class DumpOutput extends Output
{
    const PER_WRITE = 100000000; // 100mb
    const PER_FILE = 2000000000; // 2gb

    public $destination;

    protected $buffer = '';

    private $_bytesWritten = [];
    private $_channel;

    public function __construct($destination)
    {
        $this->destination = $destination;
    }

    public function output($query)
    {
        $this->buffer .= $query . PHP_EOL;

        $bufferLength = mb_strlen($this->buffer, '8bit');
        if ($bufferLength > self::PER_WRITE) {
            $this->write();
        }
    }
    
    public function finish()
    {
        if ($this->buffer) {
            $this->write();
        }
    }

    public function setChannel($channel)
    {
        if ($this->_channel != $channel) {
            $this->finish();
        }
        if (! isset($this->_bytesWritten[$channel])) {
            $this->_bytesWritten[$channel] = 0;
        }
        $this->_channel = $channel;
    }

    public function getChannel()
    {
        return $this->_channel;
    }

    protected function write()
    {
        $this->_bytesWritten[$this->_channel] += file_put_contents($this->getDestination(), $this->buffer, FILE_APPEND);
        $this->buffer = '';
    }

    protected function getDestination()
    {
        $fileN = floor($this->_bytesWritten[$this->_channel] / self::PER_FILE) + 1;
        return $this->destination . DIRECTORY_SEPARATOR . $this->channel . (($fileN > 1) ? '_' . $fileN : '') . '.sql';
    }
}