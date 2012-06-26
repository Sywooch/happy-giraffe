<?php
class positiveNumber extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        if ($object->$attribute <= 0) {
            $labels = $object->attributeLabels();
            $this->addError($object, $attribute, $labels[$attribute] . ' должно быть больше ноля');
        }
    }
}