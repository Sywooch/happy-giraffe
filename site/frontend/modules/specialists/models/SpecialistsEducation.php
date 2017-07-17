<?php

namespace site\frontend\modules\specialists\models;

/**
 * This is the model class for table "specialists__profile_education".
 *
 * The followings are the available columns in table 'specialists__profile_education':
 * @property integer $id
 * @property integer $profile_id
 * @property integer $university_id
 * @property string $specialization
 * @property string $end_year
 *
 * The followings are the available model relations:
 * @property SpecialistsUniversities $university
 *
 * @author Sergey Gubarev
 */
class SpecialistsEducation extends \HActiveRecord implements \IHToJSON
{

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'specialists__profile_education';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['profile_id', 'specialization', 'end_year', 'university_id'], 'safe']
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
            'university'    => [self::HAS_ONE, SpecialistsUniversities::class, ['id' => 'university_id']]
        ];
    }
    
    /**
     * Года
     *
     * @return string Год окончания
     */
    public function getYears()
    {
        return $this->end_year;
    }
    
    /**
     * Место
     *
     * @return string В формате [университет, специализация]
     */
    public function getPlace() {
        $output = [];
        
        if ($this->university)
        {
            $output[] = $this->university->name;
        }
        
        $output[] = $this->specialization;
        
        return implode(', ', $output);
    }

    /**
     * @return array
     */
    public function toJSON()
    {
        return [
            'id'                => $this->id,
            'specialization'    => $this->specialization,
            'end_year'          => $this->end_year,
            'university'        => $this->university
        ];
    }

}