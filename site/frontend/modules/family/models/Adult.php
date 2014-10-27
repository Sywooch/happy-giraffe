<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\models;


class Adult extends RealFamilyMember
{
    public $type = 'adult';
    public $relationshipStatus;

    private $_oldRelationshipStatus;

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(

        ));
    }

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

    protected function afterFind()
    {
        if ($this->family !== null && $this->family->adultsRelationshipStatus !== null) {
            $this->relationshipStatus = $this->_oldRelationshipStatus = $this->family->adultsRelationshipStatus;
        }
    }

    protected function afterSave()
    {
        if ($this->isNewRecord || ($this->relationshipStatus != $this->_oldRelationshipStatus)) {
            $this->family->adultsRelationshipStatus = $this->relationshipStatus;
            $this->family->save();
        }
        parent::afterSave();
    }

    protected function canBeAdded()
    {
        return ! FamilyMember::model()->family($this->familyId)->gender($this->gender)->exists();
    }
} 