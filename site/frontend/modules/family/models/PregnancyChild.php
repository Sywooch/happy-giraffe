<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


use site\frontend\modules\family\components\AgeHelper;
use site\frontend\modules\family\models\viewData\PregnancyChildViewData;

class PregnancyChild extends FamilyMemberAbstract
{
    const GENDER_TWINS = 2;
    const PREGNANCY_MONTHS = 9;

    public $type = 'waiting';

    static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function getViewDataInternal()
    {
        return new PregnancyChildViewData($this);
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('birthday', 'required'),
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE, self::GENDER_TWINS)),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
            array('birthday', 'validateBirthday'),
            array('type', 'site\frontend\modules\family\components\WaitingChildValidator', 'on' => 'insert'),
        ));
    }

    /**
     * @param $attribute
     * @todo Возможно, улучшить сообщения об ошибках
     */
    public function validateBirthday($attribute)
    {
        $birthday = new \DateTime($this->$attribute);
        $now = new \DateTime();
        $interval = $now->diff($birthday);
        if ($interval->invert == 1 || $interval->m > self::PREGNANCY_MONTHS) {
            $this->addError($attribute, 'Некорректная дата родов');
        }
    }

    public function toJSON()
    {
        return \CMap::mergeArray(parent::toJSON(), array(
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'pregnancyTermString' => AgeHelper::getPregnancyTermString($this->birthday),
        ));
    }
} 