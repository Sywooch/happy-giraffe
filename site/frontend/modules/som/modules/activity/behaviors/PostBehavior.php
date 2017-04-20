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
class PostBehavior extends ActivityBehavior
{
    protected $oldEntityId;

    public function afterFind($event)
    {
        $this->oldEntityId = $this->owner->originEntityId;
    }

    public function afterSave($event)
    {
        $this->delActivity();
        $this->addActivity();
    }

    public function getActivityId()
    {
        $originEntityId = (!$this->oldEntityId) ? $this->owner->originEntityId : $this->oldEntityId;
        return md5($this->owner->originService . '|' . $this->owner->originEntity . '|' . $originEntityId);
    }

    public function getActivityModel()
    {
        $activity       = new Activity();
        $activity->data = array(
            'title' => $this->owner->title,
            'url'   => $this->owner->url,
            'text'  => $this->owner->preview,
        );
        $activity->dtimeCreate = (int) $this->owner->dtimeCreate;
        $activity->userId      = (int) $this->owner->authorId;
        $activity->typeId      = isset($this->owner->templateObject->data['type']) ? $this->owner->templateObject->data['type'] : 'post';

        return $activity;
    }

    public function getIsRemoved()
    {
        return $this->owner->isRemoved || !$this->owner->originEntityId;
    }

}
