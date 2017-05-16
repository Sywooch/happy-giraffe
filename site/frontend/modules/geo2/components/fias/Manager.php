<?php
/**
 * @author Никита
 * @date 22/02/17
 */

namespace site\frontend\modules\geo2\components\fias;


use site\frontend\modules\geo2\components\fias\handler\IHandler;
use site\frontend\modules\geo2\components\fias\handler\MySQLHandler;
use site\frontend\modules\geo2\components\fias\output\Output;
use site\frontend\modules\geo2\components\fias\update\VersionManager;

class Manager
{
    public $schemaDestination;
    public $dataDestination;
    public $handler;
    public $output;

    public function __construct(IHandler $handler, Output $output, $dataDestination = null)
    {
        $this->schemaDestination = \Yii::getPathOfAlias('site.frontend.modules.geo2.data.xsd') . DIRECTORY_SEPARATOR;
        $this->dataDestination = $dataDestination ? $dataDestination : (new ArchiveGetter('http://fias.nalog.ru/Public/Downloads/Actual/fias_xml.rar'))->get();
        $this->handler = $handler;
        $this->output = $output;
    }

    public function import()
    {
        $map = $this->mapFiles();

        foreach ($map as $tableName => $files) {
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
        
        (new VersionManager())->setCurrentVersion();
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