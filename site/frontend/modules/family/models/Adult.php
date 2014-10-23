<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


class Adult extends RealFamilyMember
{
    public $type = 'adult';

    public function getTitle()
    {
        $titles = array(
            'friends' => array(
                0 => 'Подруга',
                1 => 'Друг',
            ),
            'engaged' => array(
                0 => 'Невеста',
                1 => 'Жених',
            ),
            'married' => array(
                0 => 'Жена',
                1 => 'Муж',
            ),
        );

        return $titles[$this->adultRelationshipStatus][$this->gender];
    }
} 