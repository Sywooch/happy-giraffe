<?php

namespace site\frontend\modules\specialists\models;
use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;

/**
 * This is the model class for table "specialists__universities".
 *
 * The followings are the available columns in table 'specialists__universities':
 * @property integer $id
 * @property integer $group_id
 * @property integer $country_id
 * @property integer $city_id
 * @property string $name
 * @property string $site
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Geo2City $city
 * @property Geo2Country $country
 *
 * @author Sergey Gubarev
 */
class SpecialistsUniversities extends \HActiveRecord implements \IHToJSON
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
            'city'      => [self::HAS_ONE, Geo2City::class, ['id' => 'city_id']],
            'country'   => [self::HAS_ONE, Geo2Country::class, ['id' => 'country_id']]
        );
    }

    /**
     * @return array
     */
    public function toJSON()
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'site'      => $this->site,
            'address'   => $this->address,
            'city'      => $this->city,
            'country'   => $this->country
        ];
    }

}