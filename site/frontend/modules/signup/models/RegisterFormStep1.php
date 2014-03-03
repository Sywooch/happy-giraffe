<?php
/**
 * Форма обработки 1 шага регистрации
 *
 * Несмотря на то, что реализует первый шаг, уже сохраняет пользователя перманентно
 */

class RegisterFormStep1 extends CFormModel
{
    public $first_name;
    public $last_name;
    public $email;

    private $_user;

    public function rules()
    {
        return array(
            array('first_name, last_name, email', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'E-mail',
        );
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function save()
    {
        $this->_user = new User();
        $this->_user->attributes = $this->attributes;
        return $this->_user->save();
    }
}