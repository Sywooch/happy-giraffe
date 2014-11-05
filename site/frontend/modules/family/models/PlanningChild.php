<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


class PlanningChild extends WaitingChild
{
    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE)),
        ));
    }

    public function getTitle()
    {
        return 'Планируем ребенка';
    }
} 