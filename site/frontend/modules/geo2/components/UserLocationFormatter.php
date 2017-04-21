<?php
/**
 * @author Никита
 * @date 21/04/17
 */

namespace site\frontend\modules\geo2\components;


use site\frontend\modules\geo2\models\UserLocation;

class UserLocationFormatter
{
    static public function cityAndRegion(UserLocation $location)
    {
        $parts = [];
        if ($location->cityId) {
            $parts[] = $location->city->title;
        }
        if ($location->regionId) {
            $parts[] = str_replace('область', 'обл.', $location->region->title);
        }
        return implode(', ', $parts);
    }
}