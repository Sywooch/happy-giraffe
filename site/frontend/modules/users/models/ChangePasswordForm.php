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

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function rules()
    {
        return array(
            array('password', 'required'),
            array('password', 'length', 'min' => 6, 'max' => 15),
        );
    }

    public function save()
    {
        $this->user->password = User::hashPassword($this->password);
        return $this->user->save(false, array('password'));
    }
} 