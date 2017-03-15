<?php
/**
 * @author Никита
 * @date 09/03/17
 */

namespace site\frontend\modules\geo2\components\vk;


use site\frontend\modules\geo2\components\combined\modifier\VkModifier;
use site\frontend\modules\geo2\components\vk\models\City;
use site\frontend\modules\geo2\components\vk\models\Country;
use site\frontend\modules\geo2\components\vk\models\VkCity;
use site\frontend\modules\geo2\components\vk\models\VkCountry;
use site\frontend\modules\geo2\components\vk\models\VkRegion;

class Manager
{
    const COUNTRY_TABLE = 'vk__countries';
    const REGIONS_TABLE = 'vk__regions';
    const CITIES_TABLE = 'vk__cities';
    const INSERT_LIMIT = 1000;

    private $_parser;
    private $_syncActions = [];

    public function __construct()
    {
        $this->_parser = new Parser();
    }

    public function init()
    {
        $this->clean();

        foreach ($this->_parser->getCountries() as $country) {
            echo $country['id'] . PHP_EOL;

            \Yii::app()->db->createCommand()->insert(VkCountry::model()->tableName(), $this->countryRow($country));

            $regions = $this->_parser->getRegions($country['id']);
            $regionsMap = [];
            foreach ($regions as $region) {
                \Yii::app()->db->createCommand()->insert(VkRegion::model()->tableName(), $this->regionRow($country, $region));
                $regionsMap[$region['title']] = $region;
            }

            $cities = $this->_parser->getCities($country['id']);
            $nCities = count($cities);
            for ($i = 0; $i < ceil($nCities / self::INSERT_LIMIT); $i++) {
                $citiesRows = array_map(function($city) use ($regionsMap, $country) {
                    return $this->cityRow($country, (isset($city['region']) && isset($regionsMap[$city['region']])) ? $regionsMap[$city['region']] : null, $city);
                }, array_slice($cities, self::INSERT_LIMIT * $i, self::INSERT_LIMIT));
                \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand(VkCity::model()->tableName(), $citiesRows)->execute();
            }
        }
    }

    public function update($dryRun)
    {
        $a = microtime(true);
        $this->collectSyncActions();
        $this->preProcessActions();
        echo PHP_EOL . (microtime(true) - $a) . ' секунд' . PHP_EOL;

        print_r($this->_syncActions);
        if (! $dryRun) {
            $this->performActions();
        }
    }

    protected function collectSyncActions()
    {
        $countriesGenerator = $this->_parser->getCountries();
        $this->_collectSyncActions(VkCountry::model()->tableName(), $this->_parser->getCountries(), \Yii::app()->db->createCommand()->select()->from(VkCountry::model()->tableName())->queryAll(), [$this, 'countryRow']);
        foreach ($countriesGenerator as $i => $country) {
            echo $country['id'] . ' - ' . count($this->_syncActions) . PHP_EOL;

            $regionsGenerator = $this->_parser->getRegions($country['id']);
            $dbRegions = \Yii::app()->db->createCommand()->select()->from(VkRegion::model()->tableName())->where('countryId = :countryId')->queryAll(true, [':countryId' => $country['id']]);
            $this->_collectSyncActions(VkRegion::model()->tableName(), $regionsGenerator, $dbRegions, function($region) use ($country) {
                return $this->regionRow($country, $region);
            });

            $regionsMap = [];
            foreach ($regionsGenerator as $region) {
                $regionsMap[$region['title']] = $region;
            }
            $dbCities = \Yii::app()->db->createCommand()->select()->from(VkCity::model()->tableName())->where('countryId = :countryId')->queryAll(true, [':countryId' => $country['id']]);
            $this->_collectSyncActions(VkCity::model()->tableName(), $this->_parser->getCities($country['id']), $dbCities, function($city) use ($country, $regionsMap) {
                return $this->cityRow($country, (isset($city['region']) && isset($regionsMap[$city['region']])) ? $regionsMap[$city['region']] : null, $city);
            });
        }
    }

    protected function performActions()
    {
        foreach ($this->_syncActions as $table => $methods) {
            foreach ($methods as $method => $rows) {
                foreach ($rows as $id => $row) {
                    switch ($method) {
                        case 'insert':
                            VkModifier::instance()->insert($table, $row);
                            break;
                        case 'update':
                            VkModifier::instance()->update($table, $row, $id);
                            break;
                        case 'delete':
                            VkModifier::instance()->delete($table, $row, $id);
                            break;
                        default:
                            throw new \CException();
                    }
                }
            }
        }
    }

    protected function _collectSyncActions($table, $rows, $dbRows, $populateRow)
    {
        $_dbRows = [];
        foreach ($dbRows as $dbRow) {
            $_dbRows[$dbRow['id']] = $dbRow;
        }

        foreach ($rows as $row) {
            $row = $populateRow($row);
            if (isset($_dbRows[$row['id']])) {
                if ($_dbRows[$row['id']] != $row) {
                    $this->addSyncAction($table, 'update', $row);
                }
            } else {
                $this->addSyncAction($table, 'insert', $row);
            }
            unset($_dbRows[$row['id']]);
        }

        foreach ($_dbRows as $row) {
            $this->addSyncAction($table, 'delete', $row);
        }
    }

    protected function preProcessActions()
    {
        foreach ($this->_syncActions as $table => $methods) {
            if (isset($methods['delete'])) {
                foreach ($methods['delete'] as $id => $row) {
                    if (isset($methods['insert'][$id])) {
                        $this->addSyncAction($table, 'update', $methods['insert'][$id]);
                        $this->removeSyncAction($table, 'delete', $id);
                        $this->removeSyncAction($table, 'insert', $id);
                    }
                }
            }
        }
    }

    protected function addSyncAction($table, $method, $row)
    {
        if (! isset($this->_syncActions[$table])) {
            $_syncActions[$table] = [];
        }

        if (! isset($this->_syncActions[$table][$method])) {
            $_syncActions[$table][$method] = [];
        }

        $this->_syncActions[$table][$method][$row['id']] = $row;
    }

    protected function removeSyncAction($table, $method, $rowId)
    {
        unset($this->_syncActions[$table][$method][$rowId]);
    }

    protected function countryRow($country)
    {
        return array_merge($country, ['iso' => $this->_parser->getCountryCode($country['title'])]);
    }

    protected function regionRow($country, $region)
    {
        return array_merge($region, ['countryId' => $country['id']]);
    }

    protected function cityRow($country, $region, $city)
    {
        return array_merge(array_intersect_key($city, array_flip(['id', 'title'])), ['countryId' => $country['id'], 'regionId' => ($region === null) ? null : $region['id']]);
    }

    protected function clean()
    {
        foreach([VkCountry::model()->tableName(), VkRegion::model()->tableName(), VkCity::model()->tableName()] as $table) {
            \Yii::app()->db->createCommand()->delete($table);
        }
    }
}