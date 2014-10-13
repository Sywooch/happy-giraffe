<?php

/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 15/01/14
 * Time: 14:49
 */
class SoftDeleteBehavior extends CActiveRecordBehavior
{

    public function attach($owner)
    {
        if (!$owner->hasAttribute('removed'))
            throw new Exception('На данную модель нельзя добавить поведение ' . __CLASS__);

        return parent::attach($owner);
    }

    public function beforeDelete($event)
    {
        $this->softDelete();
        $event->isValid = false;
    }

    public function restore()
    {
        return $this->softRestore();
    }

    public function softDelete()
    {
        $result = false;
        if ($this->beforeSoftDelete())
        {
            $model = new SoftDelete();
            $model->entity = get_class($this->owner);
            $model->entity_id = $this->owner->id;
            $model->user_id = Yii::app()->user->id;
            $result = $model->save();
            $this->owner->removed = 1;
            $result = $result && $this->owner->update(array('removed'));
            if ($result)
                $this->afterSoftDelete();
        }
        return $result;
    }

    public function softRestore()
    {
        $result = false;
        if ($this->beforeSoftRestore())
        {
            $this->owner->removed = 0;
            $result = $this->owner->update(array('removed'));
            if ($result)
                $this->afterSoftRestore();
        }

        return $result;
    }

    /* events */

    public function beforeSoftDelete()
    {
        if ($this->owner->hasEventHandler('onBeforeSoftDelete'))
        {
            $event = new CModelEvent($this->owner);
            $this->onBeforeSoftDelete($event);
            return $event->isValid;
        }

        return true;
    }

    public function onBeforeSoftDelete($event)
    {
        $this->owner->raiseEvent('onBeforeSoftDelete', $event);
    }

    public function afterSoftDelete()
    {
        if ($this->owner->hasEventHandler('onAfterSoftDelete'))
            $this->onAfterSoftDelete(new CEvent($this->owner));
    }

    public function onAfterSoftDelete($event)
    {
        $this->owner->raiseEvent('onAfterSoftDelete', $event);
    }

    public function beforeSoftRestore()
    {
        if ($this->owner->hasEventHandler('onBeforeSoftRestore'))
        {
            $event = new CModelEvent($this->owner);
            $this->onBeforeSoftRestore($event);
            return $event->isValid;
        }

        return true;
    }

    public function onBeforeSoftRestore($event)
    {
        $this->owner->raiseEvent('onBeforeSoftRestore', $event);
    }

    public function notRemoved()
    {
        $this->owner->getDbCriteria()->compare($this->owner->getTableAlias(), 0);
        return $this;
    }

    public function afterSoftRestore()
    {
        if ($this->owner->hasEventHandler('onAfterSoftRestore'))
            $this->onAfterSoftRestore(new CEvent($this->owner));
    }

    public function onAfterSoftRestore($event)
    {
        $this->owner->raiseEvent('onAfterSoftRestore', $event);
    }
}











