<?php
/**
 * @author Никита
 * @date 27/12/14
 */

namespace site\frontend\modules\users\models;


class ChangeEmailForm extends \CFormModel
{
    public $user;
    public $email;
    public $oldPassword;

    public function __construct(User $user, $email, $oldPassword)
    {
        $this->user = $user;
        $this->email = $email;
        $this->oldPassword = $oldPassword;
    }

    public function rules()
    {
        return array(
            array('email', 'email'),
            array('oldPassword', 'site\frontend\modules\users\components\OldPasswordValidator', 'passwordHash' => $this->user->password),
            array('email', 'unique', 'className' => '\site\frontend\modules\users\models\User', 'caseSensitive' => false, 'criteria' => array('condition' => 'deleted = 0')),
        );
    }

    public function save()
    {
        $this->user->email = $this->email;
        return $this->user->save(false, array('email'));
    }
} 