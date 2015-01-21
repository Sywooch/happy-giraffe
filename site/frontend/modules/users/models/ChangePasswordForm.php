<?php
/**
 * @author Никита
 * @date 27/12/14
 */

namespace site\frontend\modules\users\models;


class ChangePasswordForm extends \CFormModel
{
    public $user;
    public $password;
    public $oldPassword;

    public function __construct(User $user, $password, $oldPassword)
    {
        $this->user = $user;
        $this->password = $password;
        $this->oldPassword = $oldPassword;
    }

    public function rules()
    {
        return array(
            array('password, oldPassword', 'required'),
            array('oldPassword', 'validateOldPassword'),
            array('password', 'length', 'min' => 6, 'max' => 15),
        );
    }

    public function validateOldPassword($attribute)
    {
        if (User::hashPassword($this->$attribute) != $this->user->password) {
            $this->addError($attribute, 'Текущий пароль введен неверно');
        }
    }

    public function save()
    {
        $this->user->password = User::hashPassword($this->password);
        return $this->user->save(false, array('password'));
    }
} 