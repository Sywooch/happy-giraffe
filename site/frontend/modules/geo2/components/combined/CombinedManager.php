<?php

namespace site\frontend\modules\geo2\components\combined;
use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\combined\models\Geo2Region;
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
            ->order('id ASC')
        ;

        $this->batchInsert($select, [VkModifier::instance(), 'convertCountry'], Geo2Country::model()->tableName());
    }

    protected function initRegions()
    {
        $_countries = \Yii::app()->db->createCommand()->select()->from(Geo2Country::model()->tableName())->queryAll();
        $countries = [];
        foreach ($_countries as $_country) {
            $countries[$_country['vkId']] = $_country;
        }

        $this->initVkRegions();
        $this->initFiasRegions($countries);
    }

    protected function initVkRegions()
    {
        $select = \Yii::app()->db->createCommand()
            ->select()
            ->from(VkRegion::model()->tableName())
            ->where('countryId != :russiaId', [':russiaId' => self::RUSSIA_VK_ID])
            ->order('id ASC')
        ;
        $this->batchInsert($select, [VkModifier::instance(), 'convertRegion'], Geo2Region::model()->tableName());
    }

    protected function initFiasRegions($countries)
    {
        $select = \Yii::app()->db->createCommand()
            ->select('AOID, FORMALNAME')
            ->from(FiasAddrobj::model()->tableName())
            ->where('LIVESTATUS = 1 AND AOLEVEL = 1')
            ->order('AOID ASC')
        ;
        $this->batchInsert($select, function($row) use ($countries) {
            return [
                'countryId' => $countries[self::RUSSIA_VK_ID]['id'],
                'title' => $row['FORMALNAME'],
                'fiasId' => $row['AOGUID'],
            ];
        }, Geo2Region::model()->tableName());
    }

    protected function initCities()
    {
        $regions = \Yii::app()->db->createCommand()
            ->select()
            ->from(Geo2Region::model()->tableName())
            ->queryAll()
        ;

        $vkRegions = [];
        $fiasRegions = [];
        foreach ($regions as $region) {
            if ($region['vkId']) {
                $vkRegions[$region['vkId']] = $region;
            } else {
                $fiasRegions[$region['fiasId']] = $region;
            }
        }

        $this->initVkCities($vkRegions);
        $this->initFiasCities($fiasRegions);
    }

    protected function initVkCities($vkRegions)
    {
        $select = \Yii::app()->db->createCommand()
            ->select()
            ->from(VkCity::model()->tableName())
            ->where('countryId != :countryId', [':countryId' => self::RUSSIA_VK_ID])
            ->order('id ASC')
        ;
        $this->batchInsert($select, [VkModifier::instance(), 'convertCity'], Geo2City::model()->tableName());
    }

    protected function initFiasCities($fiasRegions)
    {
        foreach ($fiasRegions as $fiasId => $region) {
            $parents = [$fiasId];
            do {
                $cities = \Yii::app()->db->createCommand()
                    ->select()
                    ->from(FiasAddrobj::model()->tableName())
                    ->where(['in', 'PARENTGUID', $parents])
                    ->andWhere('LIVESTATUS = 1 AND AOLEVEL IN (4, 6)')
                    ->order('AOID ASC')
                ;

                $parents = \Yii::app()->db->createCommand()
                    ->select()
                    ->from(FiasAddrobj::model()->tableName())
                    ->where(['in', 'PARENTGUID', $parents])
                    ->andWhere('LIVESTATUS = 1 AND AOLEVEL NOT IN (4, 6)')
                    ->queryColumn()
                ;

                $this->batchInsert($cities, function($row) use ($region) {
                    return [
                        'countryId' => $region['countryId'],
                        'regionId' => $region['id'],
                        'title' => $row['FORMALNAME'],
                        'fiasId' => $row['AOID'],
                    ];
                }, Geo2City::model()->tableName());
            } while (! empty($parents));
        }
    }

    protected function batchInsert(\CDbCommand $select, $callback, $destination)
    {
        $count = clone $select;
        $count = $count->select('COUNT(*)')->queryScalar();

        $select
            ->select('*')
            ->limit(self::BATCH_SIZE)
        ;

        for ($i = 0; $i < ceil($count / self::BATCH_SIZE); $i++) {
            $select->offset(self::BATCH_SIZE * $i);
            $rows = $select->queryAll();
            $processedRows = array_map(function($row) use ($callback) {
                return $callback($row);
            }, $rows);

            \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand($destination, $processedRows)->execute();
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