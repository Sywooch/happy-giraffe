<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\components;


use site\frontend\modules\family\models\api\FamilyMember;

class FamilyBehavior extends \CActiveRecordBehavior
{
    public function afterSave($event)
    {
        /** @var \site\frontend\modules\family\models\api\FamilyMember $member */
        $member = FamilyMember::model();
        $member->setIsNewRecord(false);
        $member->setByUser($this->owner);
        $member->update();
    }
}