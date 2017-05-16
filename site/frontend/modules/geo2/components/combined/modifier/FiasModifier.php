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

    private $_regions;
    private $_countryId;
    private $_possibleParents;

    public function convertCountry($row)
    {
        throw new \Exception('Unsupported');
    }

    public function convertRegion($row)
    {
        return [
            'countryId' => $this->getCountryId(),
            'title' => $this->getRegionTitle($row),
            'fiasId' => $row['AOGUID'],
        ];
    }

    public function convertCity($row)
    {
        return [
            'countryId' => $this->getCountryId(),
            'regionId' => $this->getRegionId($row),
            'area' => $this->getDistrictName($row),
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

    private function getRegionTitle($row)
    {
        $prefix = '';
        $postfix = '';
        switch ($row['SHORTNAME']) {
            case 'край':
                $postfix = $row['SHORTNAME'];
                break;
            case 'АО':
                $postfix = 'автономный округ';
                break;
            case 'Аобл':
                $postfix = 'автономная область';
                break;
            case 'г':
                $prefix = 'г.';
                break;
            case 'обл':
                $postfix = 'область';
                break;
            case 'Респ':
                $prefix = 'Республика';
                break;
        }
        return implode(' ', [$prefix, $row['FORMALNAME'], $postfix]);
    }

    private function getCountryId()
    {
        if (! $this->_countryId) {
            $this->_countryId = Geo2Country::model()->iso('RU')->find()->id;
        }
        return $this->_countryId;
    }

    private function getRegionId($city)
    {
        $parents = $this->getWithParents($city['PARENTGUID']);
        $region = $this->getParentByAOLEVEL($parents, 1);
        return $region ? $this->getRegions()[$region['AOGUID']] : null;
    }

    private function getDistrictName($city)
    {
        $parents = $this->getWithParents($city['PARENTGUID']);
        $district = $this->getParentByAOLEVEL($parents, 3);
        return ($district) ? $district['FORMALNAME'] . ' ' . 'район' : '';
    }

    private function getParentByAOLEVEL($parents, $AOLEVEL)
    {
        foreach ($parents as $parent) {
            if ($parent['AOLEVEL'] == $AOLEVEL) {
                return $parent;
            }
        }
        return null;
    }

    private function getPossibleParents()
    {
        if (! $this->_possibleParents) {
            $_parents = \Yii::app()->db->createCommand()
                ->select()
                ->from(FiasAddrobj::model()->tableName())
                ->where('LIVESTATUS = 1 AND AOLEVEL IN (1, 3, 4, 5)')
                ->queryAll();
            $this->_possibleParents = [];
            foreach ($_parents as $_parent) {
                $this->_possibleParents[$_parent['AOGUID']] = $_parent;
            }
        }
        return $this->_possibleParents;
    }

    private function getWithParents($AOGUID)
    {
        $possibleParents = $this->getPossibleParents();

        $parents = [];
        while (true) {
            if (isset($possibleParents[$AOGUID])) {
                $parents[] = $possibleParents[$AOGUID];
                $AOGUID = $possibleParents[$AOGUID]['PARENTGUID'];
            } else {
                break;
            }
        }
        return $parents;
    }

    private function getRegions()
    {
        if (! $this->_regions) {
            $_regions = \Yii::app()->db->createCommand()
                ->select('AOGUID, g.id')
                ->from(FiasAddrobj::model()->tableName() . ' a')
                ->leftJoin(Geo2Region::model()->tableName() . ' g', 'g.fiasId = a.AOGUID')
                ->where('LIVESTATUS = 1 AND AOLEVEL = 1')
                ->queryAll();
            $this->_regions = [];
            foreach ($_regions as $_region) {
                $this->_regions[$_region['AOGUID']] = $_region['id'];
            }
        }
        return $this->_regions;
    }
}