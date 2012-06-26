<?php
class normalizeNumber extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        if (is_numeric(str_replace(',', '', $object->$attribute)) || is_numeric(str_replace('.', '', $object->$attribute))) {
            $object->$attribute = trim(str_replace(',', '.', $object->$attribute));
            $object->$attribute = preg_replace('#[^0-9\.]+#', '', $object->$attribute);
        } else {
            $labels = $object->attributeLabels();
            $this->addError($object, $attribute, $labels[$attribute] . ' должно быть числом');
        }
    }
}