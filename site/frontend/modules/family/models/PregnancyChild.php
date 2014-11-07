<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


class PregnancyChild extends WaitingChild
{
    const GENDER_TWINS = 2;
    const PREGNANCY_MONTHS = 9;

    public $type = 'waiting';

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE, self::GENDER_TWINS)),
            array('birthday', 'date', 'format' => 'yyyy-M-d', 'allowEmpty' => false),
            array('birthday', 'validateBirthday'),
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

    public function getTitle()
    {
        switch ($this->gender) {
            case self::GENDER_MALE:
                return 'Ждем мальчика';
            case self::GENDER_FEMALE:
                return 'Ждем девочку';
            case self::GENDER_TWINS:
                return 'Ждем двойню';
            default:
                return 'Ждем ребенка';
        }
    }

    protected function isPublic()
    {
        return time() > strtotime($this->birthday);
    }
} 