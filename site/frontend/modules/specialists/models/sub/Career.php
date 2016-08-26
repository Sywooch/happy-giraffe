<?php
/**
 * @author Никита
 * @date 24/08/16
 */

namespace site\frontend\modules\specialists\models\sub;


class Career extends Common implements \IHToJSON
{
    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), [
            ['years', 'validateYears'],
        ]);
    }

    public function validateYears($attribute, $params)
    {
        $parts = explode('-', $this->$attribute);
        if (count($parts) != 2) {
            $this->addError($attribute, 'Неверный формат');
        } else {
            foreach ($parts as $part) {
                $val = intval($part);
                if ($val < 1900 || $val > 2100) {
                    $this->addError($attribute, 'Неверный формат');
                    break;
                }
            }
        }
    }
}