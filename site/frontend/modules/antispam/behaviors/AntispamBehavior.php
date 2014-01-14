<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 14/01/14
 * Time: 16:47
 * To change this template use File | Settings | File Templates.
 */

class AntispamBehavior extends CActiveRecordBehavior
{
    public function afterSave($event)
    {
        if (AntispamStatusManager::getUserStatus(123) == AntispamStatusManager::STATUS_UNDEFINED) {
            $check = new AntispamCheck();
            $check->entity = get_class($this->owner);
            $check->entity_id = $this->owner->id;
            $check->save();
        }
    }
}