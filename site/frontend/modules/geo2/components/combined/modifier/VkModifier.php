<?php
/**
 * @author Никита
 * @date 14/03/17
 */

namespace site\frontend\modules\geo2\components\combined\modifier;


use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\combined\models\Geo2Region;
use site\frontend\modules\geo2\components\vk\models\VkCity;
use site\frontend\modules\geo2\components\vk\models\VkCountry;
use site\frontend\modules\geo2\components\vk\models\VkRegion;

class VkModifier extends Modifier
{
    protected static $_instance = null;
    
    private $_countries;
    private $_regions;

    public function convertCountry($row)
    {
        $row['vkId'] = $row['id'];
        unset($row['id']);
        return $row;
    }

    public function convertRegion($row)
    {
        $row['vkId'] = $row['id'];
        unset($row['id']);
        $row['countryId'] = $this->getCountries()[$row['countryId']]['id'];
        return $row;
    }

    public function convertCity($row)
    {
        return [
            'countryId' => $this->getCountries()[$row['countryId']]['id'],
            'regionId' => ($row['regionId']) ? $this->getRegions()[$row['regionId']]['id'] : null,
            'title' => $row['title'],
            'vkId' => $row['id'],
            'area' => isset($row['area']) ? $row['area'] : '',
        ];
    }
    
    protected function getKey()
    {
        return 'id';
    }

    protected function getFk()
    {
        return 'vkId';
    }
    
    protected function getType($table, $row)
    {
        return array_search($table, [
            self::TYPE_COUNTRY => VkCountry::model()->tableName(),
            self::TYPE_REGION => VkRegion::model()->tableName(),
            self::TYPE_CITY => VkCity::model()->tableName(),
        ]);
    }

    private function getCountries()
    {
        if (! $this->_countries) {
            $_countries = \Yii::app()->db->createCommand()
                ->select()
                ->from(Geo2Country::model()->tableName())
                ->queryAll();
            $this->_countries = [];
            foreach ($_countries as $_country) {
                $this->_countries[$_country['vkId']] = $_country;
            }
        }
        return $this->_countries;
    }

    private function getRegions()
    {
        if (! $this->_regions) {
            $_regions = \Yii::app()->db->createCommand()
                ->select()
                ->from(Geo2Region::model()->tableName())
                ->where('vkId IS NOT NULL')
                ->queryAll();
            $this->_regions = [];
            foreach ($_regions as $_region) {
                $this->_regions[$_region['vkId']] = $_region;
            }
        }
        return $this->_regions;
    }
}