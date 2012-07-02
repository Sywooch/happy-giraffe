<?php
class positiveNumber extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        if ($object->$attribute < 0) {
            $labels = $object->attributeLabels();
            $message = false;
            foreach ($object->rules() as $rule) {
                foreach (explode(',', $rule[0]) as $attr) {
                    if (trim($attr) == $attribute and $rule[1] == 'ext.validators.positiveNumber') {
                        $message = $rule['message'];
                    }
                }
            }
            $this->addError($object, $attribute, ($message) ? $message : $labels[$attribute] . ' должно быть больше ноля');
        }
    }
}