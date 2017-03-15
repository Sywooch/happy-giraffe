<?php
/**
 * @author Никита
 * @date 01/03/17
 */

namespace site\frontend\modules\geo2\components\fias\update;


use site\frontend\modules\geo2\components\combined\modifier\FiasModifier;
use site\frontend\modules\geo2\components\fias\DataParser;
use site\frontend\modules\geo2\components\fias\FileNameHelper;
use site\frontend\modules\geo2\components\fias\update\DeltaGetter;
use site\frontend\modules\geo2\components\fias\update\VersionManager;
use site\frontend\modules\geo2\Geo2Module;

class UpdateManager
{
    public $created = 0;
    public $updated = 0;
    public $deleted = 0;
    
    public $deltaGetter;
    public $versionManager;
    
    public function __construct()
    {
        $this->deltaGetter = new DeltaGetter();
        $this->versionManager = new VersionManager();
    }

    public function update()
    {
        if (! $this->versionManager->isUpdateRequired()) {
            return;
        }
        
        $deltaDestination = $this->deltaGetter->getDelta();
        foreach (new \DirectoryIterator($deltaDestination) as $file) {
            if ($file->isDot()) {
                continue;
            }

            $this->processFile($file);
        }
    }
    
    protected function processFile(\DirectoryIterator $file)
    {
        $tableName = FileNameHelper::filenameToTable($file->getFilename());
        $prefixedTableName = Geo2Module::$fias['prefix'] . $tableName;
        $pkName = Geo2Module::$fias['pks'][$tableName];
        
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            $dataParser = new DataParser($file->getPathname());
            foreach ($dataParser->parse() as $row) {
                $row = array_intersect_key($row, array_flip(\Yii::app()->db->schema->getTable($prefixedTableName)->getColumnNames()));

                $exists = \Yii::app()->db->createCommand()
                        ->select('*')
                        ->limit(1)
                        ->from($prefixedTableName)
                        ->where($pkName . ' = :pk', [':pk' => $row[$pkName]])
                        ->queryRow() !== false;

                if ($exists) {
                    $pk = $row[$pkName];
//                    unset($row[$pkName]);
//                    \Yii::app()->db->createCommand()->update("$prefixedTableName", $row, $pkName . ' = :pk', [':pk' => $pk]);
                    FiasModifier::instance()->update($prefixedTableName, $row, $pk);
                    $this->updated++;
                } else {
//                    \Yii::app()->db->createCommand()->insert("$prefixedTableName", $row);
                    FiasModifier::instance()->insert($prefixedTableName, $row);
                    $this->created++;
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
}