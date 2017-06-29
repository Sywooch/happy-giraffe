<?php

namespace site\frontend\modules\specialists\models;

use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;

/**
 * This is the model class for table "specialists__profile_career".
 *
 * The followings are the available columns in table 'specialists__profile_career':
 * @property integer $id
 * @property integer $city_id
 * @property integer $profile_id
 * @property string $place
 * @property string $position
 * @property string $start_year
 * @property string $end_year
 *
 * The followings are the available model relations:
 * @property Geo2City $city
 * @property Geo2Country $country
 *
 * @author Sergey Gubarev
 */
class SpecialistsCareer extends \HActiveRecord implements \IHToJSON
{

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'specialists__profile_career';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['profile_id', 'place', 'position', 'start_year', 'end_year', 'city_id', 'country_id'], 'safe']
        ];
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
        return [
            'profile'   => [self::HAS_ONE, SpecialistProfile::class, 'profile_id'],
            'city'      => [self::BELONGS_TO, Geo2City::class, 'city_id'],
            'country'   => [self::BELONGS_TO, Geo2Country::class, 'country_id'],
        ];
    }
    
    /**
     * Года
     *
     * @return string
     */
    public function getYears()
    {
        return implode(' - ', [$this->start_year, $this->end_year]);
    }

    /**
     * @return array
     */
    public function toJSON()
    {
        return [
            'id'            => $this->id,
            'place'         => $this->place,
            'position'      => $this->position,
            'start_year'    => $this->start_year,
            'end_year'      => $this->end_year,
            'profile_id'    => $this->profile_id,
            'city'          => !is_null($this->city) ? $this->city->toJSON() : null,
            'country'       => !is_null($this->country) ? $this->country->toJSON() : null
        ];
    }

}