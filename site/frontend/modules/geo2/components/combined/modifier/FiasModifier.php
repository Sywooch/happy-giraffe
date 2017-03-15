<?php
/**
 * @author Никита
 * @date 15/03/17
 */

namespace site\frontend\modules\geo2\components\combined\modifier;


use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\combined\models\Geo2Region;
use site\frontend\modules\geo2\components\fias\models\FiasAddrobj;

class FiasModifier extends Modifier
{
    private $_cityToRegion = [];

    protected function __construct()
    {
        $this->_cityToRegion = $this->getCityToRegion();
    }

    public function convertCountry($row)
    {
        throw new \Exception('Unsupported');
    }

    public function convertRegion($row)
    {
        return [
            'countryId' => Geo2Country::model()->iso('RU')->find()->id,
            'title' => $row['FORMALNAME'],
            'fiasId' => $row['AOGUID'],
        ];
    }

    public function convertCity($row)
    {
        $region = $this->_cityToRegion[$row['AOGUID']];

        return [
            'countryId' => $region['countryId'],
            'regionId' => $region['id'],
            'title' => $row['FORMALNAME'],
            'fiasId' => $row['AOGUID'],
        ];
    }

    protected function getType($table, $row)
    {
        switch ($row['AOLEVEL']) {
            case 1:
                return self::TYPE_REGION;
            case 4:
            case 6:
                return self::TYPE_CITY;
        }
        return false;
    }

    protected function getFk()
    {
        return 'fiasId';
    }

    protected function getCityToRegion()
    {
        $cityToRegion = [];
        foreach ($this->getRegions() as $fiasId => $region) {
            $parents = [$fiasId];
            do {
                $cities = \Yii::app()->db->createCommand()
                    ->select('AOGUID')
                    ->from(FiasAddrobj::model()->tableName())
                    ->where(['in', 'PARENTGUID', $parents])
                    ->andWhere('LIVESTATUS = 1 AND AOLEVEL IN (4, 6)')
                    ->order('AOID ASC')
                    ->queryAll()
                ;

                $parents = \Yii::app()->db->createCommand()
                    ->select('AOGUID')
                    ->from(FiasAddrobj::model()->tableName())
                    ->where(['in', 'PARENTGUID', $parents])
                    ->andWhere('LIVESTATUS = 1 AND AOLEVEL NOT IN (4, 6)')
                    ->queryColumn()
                ;

                foreach ($cities as $city) {
                    $cityToRegion[$city['AOGUID']] = $fiasId;
                }
            } while (! empty($parents));
        }

        return $cityToRegion;
    }

    private function getRegions()
    {
        $_regions = \Yii::app()->db->createCommand()
            ->select()
            ->from(Geo2Region::model()->tableName())
            ->where('fiasId IS NOT NULL')
            ->queryAll()
        ;
        $regions = [];
        foreach ($_regions as $_region) {
            $regions[$_region['fiasId']] = $_region;
        }
        return $regions;
    }
}