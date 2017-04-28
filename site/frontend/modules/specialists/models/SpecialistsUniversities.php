<?php

namespace site\frontend\modules\specialists\models;

use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\combined\models\Geo2Region;


/**
 * SpecialistsUniversities class
 *
 * @author Sergey Gubarev
 */
class SpecialistsUniversities extends \HActiveRecord
{

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'specialists__universities';
    }

    /**
     * @inheritdoc
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return array(
            'city'      => array(self::HAS_ONE, Geo2City::class, 'city_id'),
            'country'   => array(self::HAS_ONE, Geo2Country::class, 'countryId'),
            'region'    => array(self::HAS_ONE, Geo2Region::class, 'regionId'),
        );
    }

}