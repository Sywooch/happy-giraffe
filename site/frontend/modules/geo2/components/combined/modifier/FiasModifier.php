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
    protected static $_instance = null;

    private $_cityToRegion = [];
    private $_countryId;

    public function convertCountry($row)
    {
        throw new \Exception('Unsupported');
    }

    public function convertRegion($row)
    {
        return [
            'countryId' => $this->getCountryId(),
            'title' => $row['FORMALNAME'],
            'fiasId' => $row['AOGUID'],
        ];
    }

    public function convertCity($row)
    {
        //$regions = $this->getCityToRegion();

        return [
            'countryId' => $this->getCountryId(),
            'regionId' => null, //isset($regions[$row['AOGUID']]) ? $regions[$row['AOGUID']] : null,
            'title' => $row['FORMALNAME'],
            'fiasId' => $row['AOGUID'],
        ];
    }

    protected function getType($table, $row)
    {
        switch ($row['AOLEVEL']) {
            case 1:
                return $row['SHORTNAME'] == 'г' ? self::TYPE_CITY : self::TYPE_REGION;
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

    protected function getKey()
    {
        return 'AOID';
    }

    private function getCountryId()
    {
        if (! $this->_countryId) {
            $this->_countryId = Geo2Country::model()->iso('RU')->find()->id;
        }
        return $this->_countryId;
    }

    private function getCityToRegion()
    {
        if (! $this->_cityToRegion) {
            foreach ($this->getRegions() as $fiasId => $region) {
                $parents = [$fiasId];
                do {
                    $cities = \Yii::app()->db->createCommand()
                        ->select('AOGUID')
                        ->from(FiasAddrobj::model()->tableName())
                        ->where(['in', 'PARENTGUID', $parents])
                        ->andWhere('LIVESTATUS = 1 AND AOLEVEL IN (4, 6)')
                        ->order('AOID ASC')
                        ->queryAll();

                    $parents = \Yii::app()->db->createCommand()
                        ->select('AOGUID')
                        ->from(FiasAddrobj::model()->tableName())
                        ->where(['in', 'PARENTGUID', $parents])
                        ->andWhere('LIVESTATUS = 1')
                        ->queryColumn();

                    foreach ($cities as $city) {
                        $this->_cityToRegion[$city['AOGUID']] = $region;
                    }
                } while (!empty($parents));
            }
        }

        return $this->_cityToRegion;
    }

    public function getRegions()
    {
        $_regions = \Yii::app()->db->createCommand()
            ->select('AOGUID, g.id')
            ->from(FiasAddrobj::model()->tableName() . ' a')
            ->leftJoin(Geo2Region::model()->tableName() . ' g', 'g.fiasId = a.AOGUID')
            ->where('LIVESTATUS = 1 AND AOLEVEL = 1')
            ->queryAll()
        ;
        $regions = [];
        foreach ($_regions as $_region) {
            $regions[$_region['AOGUID']] = $_region['id'];
        }
        return $regions;
    }
}