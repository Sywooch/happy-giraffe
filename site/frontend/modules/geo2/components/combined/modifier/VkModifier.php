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
    private $_countries;
    private $_regions;

    protected function __construct()
    {
        $this->_countries = $this->getCountries();
        $this->_regions = $this->getRegions();
        parent::__construct();
    }

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
        $row['countryId'] = $this->_countries[$row['countryId']]['id'];
        return $row;
    }

    public function convertCity($row)
    {
        $region = $this->_regions[$row['regionId']];

        return [
            'countryId' => $region['countryId'],
            'regionId' => $region['id'],
            'title' => $row['title'],
            'vkId' => $row['id'],
        ];
    }
    
    protected function getFk()
    {
        return 'vkId';
    }
    
    protected function getType($table)
    {
        return array_search($table, [
            self::TYPE_COUNTRY => VkCountry::model()->tableName(),
            self::TYPE_REGION => VkRegion::model()->tableName(),
            self::TYPE_CITY => VkCity::model()->tableName(),
        ]);
    }

    private function getCountries()
    {
        $_countries = \Yii::app()->db->createCommand()
            ->select()
            ->from(Geo2Country::model()->tableName())
            ->queryAll()
        ;
        $countries = [];
        foreach ($_countries as $_country) {
            $countries[$_country['vkId']] = $_country;
        }
        return $countries;
    }

    private function getRegions()
    {
        $_regions = \Yii::app()->db->createCommand()
            ->select()
            ->from(Geo2Region::model()->tableName())
            ->where('vkId IS NOT NULL')
            ->queryAll()
        ;
        $regions = [];
        foreach ($_regions as $_region) {
            $regions[$_region['vkId']] = $_region;
        }
        return $regions;
    }
}