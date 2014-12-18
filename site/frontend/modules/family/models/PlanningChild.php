<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


use site\frontend\modules\family\models\viewData\PlanningChildViewData;

class PlanningChild extends FamilyMemberAbstract
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
            array('planningWhen', 'required'),
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE)),
            array('planningWhen', 'in', 'range' => array(self::WHEN_SOON, self::WHEN_NEXT3YEARS)),
            array('type', 'site\frontend\modules\family\components\WaitingChildValidator', 'on' => 'insert'),
        ));
    }

    public function isPublic()
    {
        return parent::isPublic() && (time() < $this->getExpirationTime());
    }

    public function toJSON()
    {
        return \CMap::mergeArray(parent::toJSON(), array(
            'gender' => $this->gender,
            'planningWhen' => $this->planningWhen,
        ));
    }

    protected function getExpirationTime()
    {
        switch ($this->planningWhen) {
            case self::WHEN_SOON:
                return strtotime('+1 year', $this->created);
            case self::WHEN_NEXT3YEARS;
                return strtotime('+3 year', $this->created);
            default:
                throw new \CException('Wrong type value');
        }
    }
} 