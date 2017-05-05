<?php
/**
 * @author Никита
 * @date 09/09/16
 */

namespace site\frontend\modules\specialists\models;


class RegisterForm extends \site\frontend\modules\signup\models\RegisterForm
{
    public $middleName;
    
    public function save()
    {
        $this->user->middle_name = $this->middleName;
        return parent::save();
    }

    public function rules()
    {
        return [
            ['firstName, middleName, lastName, email, password, gender', 'required'],
            ['firstName, middleName, lastName', 'length', 'max' => 50],
            ['email', 'email'],
            ['email', 'unique', 'className' => 'User', 'caseSensitive' => false, 'criteria' => ['scopes' => ['active']]],
            ['password', 'length', 'min' => 6, 'max' => 15],
            ['gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE)],
            ['firstName, lastName, middleName', 'filter', 'filter' => ['Str', 'ucFirst']],
        ];
    }
}