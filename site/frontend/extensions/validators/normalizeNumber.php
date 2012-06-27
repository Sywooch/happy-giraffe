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
            $message = false;
            foreach ($object->rules() as $rule) {
                foreach (explode(',', $rule[0]) as $attr) {
                    if (trim($attr) == $attribute and $rule[1] == 'ext.validators.normalizeNumber') {
                        $message = $rule['message'];
                    }
                }
            }
            $this->addError($object, $attribute, ($message) ? $message : $labels[$attribute] . ' должно быть числом');
        }
    }
}