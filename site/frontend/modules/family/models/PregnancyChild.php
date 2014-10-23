<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


class PregnancyChild extends Pregnancy
{
    public function getTitle()
    {
        return ($this->gender == 0) ? 'Ждем девочку' : 'Ждем мальчика';
    }
} 