<?php

namespace site\frontend\modules\specialists\components;

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
     * Получить ФИО
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
}