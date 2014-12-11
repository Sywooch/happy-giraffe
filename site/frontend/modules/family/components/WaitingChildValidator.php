<?php
/**
 * @author Никита
 * @date 21/11/14
 */

namespace site\frontend\modules\family\components;


use site\frontend\modules\family\models\FamilyMember;

class WaitingChildValidator extends \CValidator
{
    public function validateAttribute($object, $attribute)
    {
        if (FamilyMember::model()->type(array('planning', 'waiting'))->family($object->familyId)->exists()) {
            $object->addError($attribute, 'В семье может быть только один ожидаемый ребенок');
        }
    }
} 