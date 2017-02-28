<?php
/**
 * @author Никита
 * @date 22/02/17
 */

namespace site\frontend\modules\geo2\components\fias\output;


class DumpOutput extends Output
{
    const PER_WRITE = 100 * 1000000;
    const PER_FILE = 2000 * 1000000;

    public $destination;

    protected $buffer = '';

    private $_bytesWritten = 0;
    private $_fileN = 1;
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

        if ($this->_bytesWritten > self::PER_FILE) {
            $this->_fileN += 1;
            $this->_bytesWritten = 0;
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
        $this->_channel = $channel;
    }

    public function getChannel()
    {
        return $this->_channel;
    }

    protected function write()
    {
        $this->_bytesWritten += file_put_contents($this->getDestination(), $this->buffer, FILE_APPEND);
        $this->buffer = '';
    }

    protected function getDestination()
    {
        return $this->destination . DIRECTORY_SEPARATOR . $this->channel . (($this->_fileN > 1) ? '_' . $this->_fileN : '') . '.sql';
    }
}