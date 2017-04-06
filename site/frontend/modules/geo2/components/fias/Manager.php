<?php
/**
 * @author Никита
 * @date 22/02/17
 */

namespace site\frontend\modules\geo2\components\fias;


use site\frontend\modules\geo2\components\fias\handler\IHandler;
use site\frontend\modules\geo2\components\fias\handler\MySQLHandler;
use site\frontend\modules\geo2\components\fias\output\Output;

class Manager
{
    public $schemaDestination;
    public $dataDestination;
    public $handler;
    public $output;

    public function __construct($schemaDestination, IHandler $handler, Output $output)
    {
        $this->schemaDestination = $schemaDestination;
        $this->dataDestination = (new ArchiveGetter('http://fias.nalog.ru/Public/Downloads/Actual/fias_xml.rar'))->get();
        $this->handler = $handler;
        $this->output = $output;
    }

    public function import()
    {
        $map = $this->mapFiles();

        $matched = false;
        foreach ($map as $tableName => $files) {
            if ($tableName != 'NORMDOC' && ! $matched) {
                continue;
            } else {
                $matched = true;
            }

            $schemaParser = new SchemaParser($files['schema']);
            $schema = $schemaParser->parse();
            $table = new Table($schema['comment'], $schema['fields']);
            $query = $this->handler->createTable($tableName, $table->comment, $table->fields);
            $this->output->channel = 'schema';
            $this->output->output($query);
            if (isset($files['data'])) {
                $dataParser = new DataParser($files['data']);
                foreach ($dataParser->parse() as $row) {
                    $fields = array_intersect_key($row, array_flip($table->getColumnNames()));
                    $query = $this->handler->insertRow($tableName, $fields);
                    $this->output->channel = $tableName;
                    $this->output->output($query);
                }
            }
        }
        $this->output->finish();
    }

    protected function mapFiles()
    {
        $map = [];
        $schemaIterator = new \DirectoryIterator($this->schemaDestination);
        foreach ($schemaIterator as $schemaFile) {
            if ($schemaFile->isDot() === true) {
                continue;
            }
            $tableName = $this->filenameToTable($schemaFile);
            $map[$tableName]['schema'] = $this->schemaDestination . $schemaFile;
        }

        $dataIterator = new \DirectoryIterator($this->dataDestination);
        foreach ($dataIterator as $dataFile) {
            if ($dataFile->isDot() === true) {
                continue;
            }
            $tableName = $this->filenameToTable($dataFile);
            if (isset ($map[$tableName])) {
                $map[$tableName]['data'] = $this->dataDestination . $dataFile;
            }
        }
        return $map;
    }

    protected function filenameToTable($filename)
    {
        $parts = explode('_', $filename);
        return $parts[1];
    }
}