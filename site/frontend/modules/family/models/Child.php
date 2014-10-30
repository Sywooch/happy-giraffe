<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


use site\frontend\modules\family\components\AgeHelper;

class Child extends RealFamilyMember
{
    public $type = 'child';

    public function getTitle()
    {
        return ($this->gender == 0) ? 'Дочь' : 'Сын';
    }

    public function getAgeString()
    {
        return AgeHelper::getChildAgeString($this->birthday);
    }
} 