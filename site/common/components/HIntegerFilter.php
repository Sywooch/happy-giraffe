<?php

namespace site\common\components;

/**
 * Description of HIntegerFilter
 *
 * @author Кирилл
 */
class HIntegerFilter extends \CFilterValidator
{

    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = (int) $model->$attribute;
    }

}

?>
