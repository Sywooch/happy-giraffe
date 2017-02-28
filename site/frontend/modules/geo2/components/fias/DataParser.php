<?php

namespace site\frontend\modules\geo2\components\fias;

/**
 * @author Никита
 * @date 22/02/17
 */
class DataParser
{
    const CHUNK_SIZE = 4096;
    
    public $path;
    private $rootIsSkipped;
    private $queue = [];

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function parse()
    {
        $parser = xml_parser_create();
        xml_set_element_handler($parser, [$this, 'startElements'], [$this, 'endElements']);

        $handle = fopen($this->path, "r");
        while ($data = fread($handle, self::CHUNK_SIZE)) {
            xml_parse($parser, $data);
            foreach ($this->queue as $row) {
                yield $row;
            }
            $this->queue = [];
        }

        fclose($handle);
        xml_parser_free($parser);
    }

    public function startElements($parser, $name, $attribs)
    {
        if (! $this->rootIsSkipped) {
            $this->rootIsSkipped = true;
        } else {
            $this->queue[] = $attribs;
        }
    }

    public function endElements($parser, $name)
    {
        
    }
}