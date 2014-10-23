<?php
/**
 * @author Никита
 * @date 23/10/14
 */

class FamilyBehavior extends CActiveRecordBehavior
{
    public function afterSave($event)
    {
        $member = \site\frontend\modules\family\models\FamilyMember::model()->user($this->id)->find();
        $this->syncFamilyMember($member);
        $member->save();
    }

    public function getFamily()
    {
        $familyMember = \site\frontend\modules\family\models\FamilyMember::model()->with('family')->user(\Yii::app()->user->id)->find();
        if ($familyMember !== null) {
            return $familyMember->family;
        }
        return $this->createFamily();
    }

    protected function createFamily()
    {
        $family = new \site\frontend\modules\family\models\Family();
        $familyMember = new \site\frontend\modules\family\models\Adult();
        $this->syncFamilyMember($familyMember);
        $family->familyMembers = array($familyMember);
        $success = $family->withRelated->save(true, array('familyMembers'));
        return ($success) ? $family : null;
    }

    protected function syncFamilyMember(&$member)
    {
        $member->gender = $this->owner->gender;
        $member->birthday = $this->owner->birthday;
        $member->name = $this->owner->firstName;
    }
} 