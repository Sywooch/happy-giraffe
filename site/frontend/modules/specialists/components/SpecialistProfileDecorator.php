<?php

namespace site\frontend\modules\specialists\components;

use site\frontend\modules\specialists\models\SpecialistProfile;

/**
 * SpecialistProfileDecorator class
 *
 * Декоратор данных для профиля врача на сайте
 *
 * @author Sergey Gubarev
 */
class SpecialistProfileDecorator
{
    /**
     * @var \User
     */
    protected $_user;

    /**
     * SpecialistProfileDecorator constructor.
     *
     * @param \User $user
     */
    public function __construct(\User $user)
    {
        $this->_user = $user;
    }

    /**
     * ФИО
     *
     * @return string
     */
    public function getFullName()
    {
        $arr = explode(' ', $this->_user->getFullName(true));

        array_walk($arr, function(&$value, $key)
        {
            if ($key == 0)
            {
                $value = $value . '<br />';
            }
        });

        return implode(' ', $arr);
    }

    /**
     * Строка - опыт врача + стаж
     *
     * @return mixed
     */
    public function getExperienceStr()
    {
        $profile    = $this->_user->specialistProfile;
        $output     = [];

        $nounDeclension = [
            SpecialistProfile::I_CATEGORY       => 'первой',
            SpecialistProfile::II_CATEGORY      => 'второй',
            SpecialistProfile::HIGHEST_CATEGORY => 'высшей'
        ];

        if ($profile->category)
        {
            $output[] = 'Врач ' . $nounDeclension[$profile->category] . ' категории';
        }

        if ($profile->experience)
        {
            $output[] = 'стаж ' . $profile->getExperienceLabel();
        }

        if ($output) {
            return implode(', ', $output);
        }
    }
}