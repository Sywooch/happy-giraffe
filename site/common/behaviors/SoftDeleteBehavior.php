<?php

/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 15/01/14
 * Time: 14:49
 */
class SoftDeleteBehavior extends CActiveRecordBehavior
{

    public $removeAttribute = 'removed';

    public function attach($owner)
    {
        if (!$owner->hasAttribute($this->removeAttribute)) {
            throw new Exception('На данную модель нельзя добавить поведение ' . __CLASS__);
        }

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
        if ($this->beforeSoftDelete()) {
            if (Yii::app() instanceof CWebApplication && Yii::app()->user->id) {
                $model = new SoftDelete();
                $model->entity = get_class($this->owner);
                $model->entity_id = $this->owner->id;
                $model->user_id = Yii::app()->user->id;
                $model->save();
            }
            $this->owner->{$this->removeAttribute} = 1;
            $result = $this->owner->save(false, $this->owner->{$this->removeAttribute});
            if ($result) {
                $this->owner->afterSoftDelete();
            }
        }
        return $result;
    }

    public function softRestore()
    {
        $result = false;
        if ($this->beforeSoftRestore()) {
            $this->owner->{$this->removeAttribute} = 0;
            $result = $this->owner->save(false, $this->owner->{$this->removeAttribute});
            if ($result) {
                $this->owner->afterSoftRestore();
            }
        }

        return $result;
    }

    /* events */

    public function beforeSoftDelete()
    {
        if ($this->owner->hasEventHandler('onBeforeSoftDelete')) {
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
        if ($this->owner->hasEventHandler('onBeforeSoftRestore')) {
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
