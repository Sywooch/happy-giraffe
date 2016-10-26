<?php
/**
 * @author Никита
 * @date 07/06/16
 */

namespace site\frontend\modules\posts\behaviors;


class HotBehavior extends \CActiveRecordBehavior
{
    const STATUS_NORMAL = 0;
    const STATUS_HOT = 1;
    const STATUS_WAS_HOT = 2;

    public function orderHotRate()
    {
        $this->owner->getDbCriteria()->mergeWith(['order' => 'hotRate DESC']);

        return $this->owner;
    }
    
    public function getIsHot()
    {
        return $this->owner->hotStatus == self::STATUS_HOT;
    }
    
    public function getWasHot()
    {
        return $this->owner->hotStatus == self::STATUS_WAS_HOT;
    }
}