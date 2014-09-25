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
        if ($this->owner->hasAttribute('removed'))
        {
            $this->softDelete();
            $event->isValid = false;
        }
    }

    public function softDelete()
    {
        $result = false;
        $model = new SoftDelete();
        $model->entity = get_class($this->owner);
        $model->entity_id = $this->owner->id;
        $model->user_id = Yii::app()->user->id;
        $result = $model->save();
        $this->owner->removed = 1;
        $result = $result && $this->owner->update(array('removed'));
        return $result;
    }

    public function restore()
    {
        if ($this->owner->hasAttribute('removed'))
        {
            $this->owner->removed = 0;
            return $this->owner->update(array('removed'));
        }
        return false;
    }

}