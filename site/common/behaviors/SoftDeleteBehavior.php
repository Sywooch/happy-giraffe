<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 15/01/14
 * Time: 14:49
 * To change this template use File | Settings | File Templates.
 */

class SoftDeleteBehavior extends CActiveRecordBehavior
{
    public function beforeDelete($event)
    {
        $model = new SoftDelete();
        $model->entity = get_class($this->owner);
        $model->entity_id = get_class($this->owner->id);
        $model->user_id = Yii::app()->user->id;
        $model->save();
        $this->owner->removed = 1;
        $this->owner->update(array('removed'));
    }

    public function restore()
    {
        $this->owner->removed = 0;
        $this->owner->update(array('removed'));
    }
}