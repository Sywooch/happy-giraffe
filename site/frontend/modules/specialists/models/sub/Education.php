<?php
/**
 * @author Никита
 * @date 26/08/16
 */

namespace site\frontend\modules\specialists\models\sub;


class Education extends Common
{
    public function attributeLabels()
    {
        return [
            'years' => 'Год окончания',
            'place' => 'Учебное заведение',
        ];
    }
}