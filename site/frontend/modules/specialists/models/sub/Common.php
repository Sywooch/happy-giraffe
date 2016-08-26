<?php
/**
 * @author Никита
 * @date 26/08/16
 */

namespace site\frontend\modules\specialists\models\sub;


class Common extends \CModel implements \IHToJSON
{
    public $years;
    public $place;

    public function attributeNames()
    {
        return [
            'years',
            'place',
        ];
    }

    public function rules()
    {
        return [
            ['years, place', 'required'],
        ];
    }

    public function toJSON()
    {
        return [
            'years' => $this->years,
            'place' => $this->place,
        ];
    }
}