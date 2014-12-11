<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\components;


class FamilyBehavior extends \CActiveRecordBehavior
{
    public function afterSave($event)
    {
        \Yii::app()->gearman->client()->doBackground('updateMember', $this->owner->id);
    }
}