<?php

namespace site\frontend\modules\geo2\components\combined;
use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\combined\models\Geo2Region;
use site\frontend\modules\geo2\components\combined\modifier\FiasModifier;
use site\frontend\modules\geo2\components\combined\modifier\VkModifier;
use site\frontend\modules\geo2\components\fias\models\FiasAddrobj;
use site\frontend\modules\geo2\components\vk\models\VkCity;
use site\frontend\modules\geo2\components\vk\models\VkCountry;
use site\frontend\modules\geo2\components\vk\models\VkRegion;

/**
 * @author Никита
 * @date 13/03/17
 */
class CombinedManager
{
    const RUSSIA_VK_ID = 1;
    const BATCH_SIZE = 10000;

    public function init()
    {
        $this->clear();
        $this->initCountries();
        $this->initRegions();
        $this->initCities();
    }
    
    protected function initCountries()
    {
        $select = \Yii::app()->db->createCommand()
            ->select()
            ->from(VkCountry::model()->tableName())
        ;



        $this->batchInsert($select, [VkModifier::instance(), 'convertCountry'], Geo2Country::model()->tableName());
    }

    protected function initRegions()
    {
        $this->initVkRegions();
        //$this->initFiasRegions();
    }

    protected function initVkRegions()
    {
        $select = \Yii::app()->db->createCommand()
            ->select()
            ->from(VkRegion::model()->tableName())
            ->where('countryId != :russiaId', [':russiaId' => self::RUSSIA_VK_ID])
        ;
        $this->batchInsert($select, [VkModifier::instance(), 'convertRegion'], Geo2Region::model()->tableName());
    }

    protected function initFiasRegions()
    {
        $select = \Yii::app()->db->createCommand()
            ->select('AOID, FORMALNAME')
            ->from(FiasAddrobj::model()->tableName())
            ->where('LIVESTATUS = 1 AND AOLEVEL = 1')
        ;
        $this->batchInsert($select, [FiasModifier::instance(), 'convertRegion'], Geo2Region::model()->tableName());
    }

    protected function initCities()
    {
        $this->initVkCities();
        //$this->initFiasCities();
    }

    protected function initVkCities()
    {
        $select = \Yii::app()->db->createCommand()
            ->select()
            ->from(VkCity::model()->tableName())
            ->where('countryId != :countryId', [':countryId' => self::RUSSIA_VK_ID])
        ;
        $this->batchInsert($select, [VkModifier::instance(), 'convertCity'], Geo2City::model()->tableName());
    }

    protected function initFiasCities()
    {
        $cities = \Yii::app()->db->createCommand()
            ->select()
            ->from(FiasAddrobj::model()->tableName())
            ->andWhere('LIVESTATUS = 1 AND AOLEVEL IN (4, 6)')
        ;

        $this->batchInsert($cities, [FiasModifier::instance(), 'convertCity'], Geo2City::model()->tableName());
    }

    protected function batchInsert(\CDbCommand $select, $callback, $destination)
    {
        $count = clone $select;
        $count = $count
            ->select('COUNT(*)')
            ->queryScalar()
        ;

        $pk = \Yii::app()->db->schema->getTable($select->getFrom())->primaryKey;
        $lastPk = 0;
        for ($i = 0; $i < ceil($count / self::BATCH_SIZE); $i++) {
            $_select = clone $select;

            //$a = microtime(true);

            $rows = $_select
                ->limit(self::BATCH_SIZE)
                ->order($pk . ' ASC')
                ->andWhere("$pk > :lastPk", [':lastPk' => $lastPk])
                ->queryAll()
            ;

            $lastPk = array_values(array_slice($rows, -1))[0][$pk];

            //echo 'selecting ' . (microtime(true) - $a) . PHP_EOL;

            //$a = microtime(true);

            $processedRows = array_map(function($row) use ($callback) {
                return $callback($row);
            }, $rows);

            //echo 'processing ' . (microtime(true) - $a) . PHP_EOL;

            //$a = microtime(true);

            try {
                \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand($destination, $processedRows)->execute();
            } catch (\Exception $e) {
                var_dump(count($rows));
                var_dump(count($processedRows));
                var_dump($lastPk);
                var_dump($_select->getText());
                throw $e;
            }

            //echo 'inserting ' . (microtime(true) - $a) . PHP_EOL;
        }
    }

    protected function clear()
    {
        foreach ([Geo2Region::model()->tableName(), Geo2Country::model()->tableName(), Geo2City::model()->tableName()] as $table) {
            \Yii::app()->db->createCommand()->delete($table);
            \Yii::app()->db->createCommand("ALTER TABLE $table AUTO_INCREMENT = 1;")->execute();
        }
    }
}