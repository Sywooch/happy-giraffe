<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


use site\frontend\modules\family\components\AgeHelper;

class Child extends FamilyMemberAbstract
{
    public $type = 'child';

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('gender', 'in', 'range' => array(self::GENDER_MALE, self::GENDER_FEMALE), 'allowEmpty' => false),
            array('birthday', 'date', 'format' => 'yyyy-M-d', 'allowEmpty' => false),
            array('birthday', 'validateBirthday'),
            array('name', 'length', 'max' => 50),
            array('description', 'length', 'max' => 1000),
        ));
    }

    public function validateBirthday($attribute)
    {
        if (time() < strtotime($this->$attribute)) {
            $this->addError($attribute, 'Некорректная дата рождения');
        }
    }

    public function getTitle()
    {
        return ($this->gender == 0) ? 'Дочь' : 'Сын';
    }

    public function getAgeString()
    {
        return AgeHelper::getChildAgeString($this->birthday);
    }
} 