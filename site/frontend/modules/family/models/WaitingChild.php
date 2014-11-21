<?php
/**
 * @author Никита
 * @date 27/10/14
 */

namespace site\frontend\modules\family\models;


abstract class WaitingChild extends FamilyMemberAbstract
{
    protected function canBeAdded()
    {
        return ! FamilyMember::model()->type(array('planning', 'waiting'))->family($this->familyId)->exists();
    }
} 