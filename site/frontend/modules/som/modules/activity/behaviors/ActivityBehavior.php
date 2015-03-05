<?php

namespace site\frontend\modules\som\modules\activity\behaviors;

use site\frontend\modules\som\modules\activity\models\api\Activity;

/**
 * Description of ActivityBehavior
 *
 * @author Кирилл
 */
abstract class ActivityBehavior extends \CActiveRecordBehavior
{

    public $isRemoved = null;

    public function attach($owner)
    {
        $this->isRemoved = $owner->isRemoved;
        return parent::attach($owner);
    }

    public function afterSave($event)
    {
        if ($this->isRemoved === $this->getIsRemoved()) {
            // Ничего не изменилось
            return;
        }

        if ($this->getIsRemoved() == 0) {
            $this->addActivity();
        }

        if ($this->getIsRemoved() == 1) {
            $this->delActivity();
        }
    }

    public function addActivity()
    {
        $activity = $this->getActivityModel();
        $activity->hash = $this->getActivityId();
        try {
            $activity->save();
        } catch (Exception $ex) {
            
        }
    }

    public function delActivity()
    {
        try {
            Activity::model()->request('removeByHash', array('hash' => $this->getActivityId()));
        } catch (\Exception $ex) {
            
        }
    }

    public abstract function getActivityId();

    public abstract function getActivityModel();
    
    public abstract function getIsRemoved();
}
