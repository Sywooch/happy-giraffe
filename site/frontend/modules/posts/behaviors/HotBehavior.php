<?php
/**
 * @author Никита
 * @date 07/06/16
 */

namespace site\frontend\modules\posts\behaviors;


class HotBehavior extends \CActiveRecordBehavior
{
    public function orderHotRate()
    {
        $this->owner->getDbCriteria()->order = 'hotRate DESC';
        return $this->owner;
    }
}