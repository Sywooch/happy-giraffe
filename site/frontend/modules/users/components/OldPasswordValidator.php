<?php
namespace site\frontend\modules\users\components;

/**
 * @author Никита
 * @date 29/01/15
 */

class OldPasswordValidator extends \CValidator
{
    public $passwordHash;

    public function validateAttribute($object, $attribute)
    {
        if (\User::hashPassword($object->$attribute) != $this->passwordHash) {
            $object->addError($attribute, 'Текущий пароль введен неверно');
        }
    }
}