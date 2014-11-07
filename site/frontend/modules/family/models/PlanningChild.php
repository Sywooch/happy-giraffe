<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


class PlanningChild extends WaitingChild
{
    const WHEN_SOON = 'soon';
    const WHEN_NEXT3YEARS = 'next3Years';

    public $type = 'planning';

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE)),
            array('planningWhen', 'in', 'range' => array(self::WHEN_SOON, self::WHEN_NEXT3YEARS), 'allowEmpty' => false),
        ));
    }

    public function getTitle()
    {
        switch ($this->gender) {
            case self::GENDER_FEMALE:
                return 'Планируем девочку';
            case self::GENDER_MALE:
                return 'Планируем мальчика';
            default:
                return 'Планируем ребенка';
        }
    }
} 