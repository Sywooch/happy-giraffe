<?php

namespace site\frontend\modules\iframe\modules\family\components;

use site\frontend\modules\iframe\modules\family\models\Family;

class FamilyManager
{

    public static function getFamilyArrayByUser($userId, $type = null, $publicOnly = true)
    {
        /** @var Family $family */
        $family = self::getFamilyByUser($userId);

        if (is_null($family))
        {
            return;
        }

        $familyData = $family->toJSON();
        $familyData['members'] = $family->getMembers($type, $publicOnly);

        return $familyData;
    }

    public static function getFamilyByUser($userId)
    {
        return Family::model()->hasMember($userId)->find();
    }

}