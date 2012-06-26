<?php
/**
 * Author: alexk984
 * Date: 28.04.12
 */
class HFormModel extends CFormModel
{
    public function normalizeLength($attribute, $params)
    {
        if (is_numeric(str_replace(',', '', $this->$attribute)) || is_numeric(str_replace('.', '', $this->$attribute))) {
            $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
            $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
        }
    }
}