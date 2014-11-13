<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


use site\frontend\modules\family\models\viewData\PlanningChildViewData;

class PlanningChild extends WaitingChild
{
    const WHEN_SOON = 'soon';
    const WHEN_NEXT3YEARS = 'next3Years';

    public $type = 'planning';

    static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function getViewDataInternal()
    {
        return new PlanningChildViewData($this);
    }

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

    public function isPublic()
    {
        return time() < $this->getExpirationTime();
    }

    public function toJSON()
    {
        return \CMap::mergeArray(parent::toJSON(), array(
            'gender' => $this->gender,
            'birthday' => $this->birthday,
        ));
    }

    protected function getExpirationTime()
    {
        return $this->created + $this->getIntervalByWhen();
    }

    protected function getIntervalByWhen()
    {
        switch ($this->planningWhen) {
            case self::WHEN_SOON:
                return strtotime('+1 year');
            case self::WHEN_NEXT3YEARS;
                return strtotime('+3 year');
            default:
                throw new \CException('Wrong type value');
        }
    }
} 