<?php

namespace site\frontend\modules\som\modules\activity\behaviors;

use site\frontend\modules\som\modules\activity\models\api\Activity;

/**
 * Description of PostBehavior
 *
 * @property \site\frontend\modules\posts\models\Content $owner Owner
 * 
 * @author Кирилл
 */
class PostBehavior extends \CActiveRecordBehavior
{

    public $isRemoved = null;

    public function attach($owner)
    {
        $this->isRemoved = $owner->isRemoved;
        return parent::attach($owner);
    }

    public function afterSave($event)
    {
        if ($this->isRemoved === $this->owner->isRemoved) {
            // Ничего не изменилось
            return;
        }

        if ($this->owner->isRemoved == 0) {
            $this->addActivity();
        }

        if ($this->owner->isRemoved == 1) {
            $this->delActivity();
        }
    }

    public function getActivityId()
    {
        return md5($this->owner->originService . '|' . $this->owner->originEntity . '|' . $this->owner->originEntityId);
    }

    public function addActivity()
    {
        $activity = new Activity();
        $activity->data = array(
            'authorId' => $this->owner->authorId,
            'title' => $this->owner->title,
            'url' => $this->owner->url,
            'text' => $this->owner->preview,
        );
        $activity->dtimeCreate = (int) $this->owner->dtimeCreate;
        $activity->userId = (int) $this->owner->authorId;
        $activity->typeId = isset($this->owner->templateObject->data['type']) ? $this->owner->templateObject->data['type'] : 'post';
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

}
