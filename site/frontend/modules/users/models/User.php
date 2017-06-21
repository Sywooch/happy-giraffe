<?php

namespace site\frontend\modules\users\models;

\Yii::import('site.common.models.User', true);
/**
 * Description of User
 *
 * @author Кирилл
 */
class User extends \User implements \IHToJSON
{
    private $_specInfo;
    private $_specialistInfo;

    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('specInfo', 'filter', 'filter' => array($this->specInfoObject, 'serialize')),
            array('specialistInfo', 'filter', 'filter' => array($this->specialistInfoObject, 'serialize')),
            array('first_name, last_name', 'length', 'max' => 50),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE))
        ));
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'fullName' => $this->getFullName(),
            'birthday' => $this->birthday,
            'avatarId' => (int) $this->avatar_id,
            'gender' => (int) $this->gender,
            'isOnline' => (bool) $this->online,
            'profileUrl' => $this->getUrl(true),
            'publicChannel' => $this->getPublicChannel(),
            'specInfo' => empty($this->specInfo) ? null : $this->specInfoObject,
            'avatarInfo' => \CJSON::decode($this->avatarInfo),
            'specialistInfo' => $this->specialistInfoObject->attributes,
            'location' => $this->location,
        );
    }

    // @todo Sergey Gubarev: Неиспользуемый функционал?!
    public function getSpecInfoObject()
    {
        if (! isset($this->_specInfo))
            $this->_specInfo = new Spec($this->specInfo, $this);

        return $this->_specInfo;
    }

    public function getSpecialistInfoObject()
    {
        if (! isset($this->_specialistInfo))
            $this->_specialistInfo = new SpecialistInfo($this->specialistInfo, $this);

        return $this->_specialistInfo;
    }
}
