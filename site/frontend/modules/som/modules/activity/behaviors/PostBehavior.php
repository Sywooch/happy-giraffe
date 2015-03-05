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

    public function getActivityId()
    {
        return md5($this->owner->originService . '|' . $this->owner->originEntity . '|' . $this->owner->originEntityId);
    }

    public function getActivityModel()
    {
        $activity = new Activiy();
        $activity->data = array(
            'title' => $this->owner->title,
            'url' => $this->owner->url,
            'text' => $this->owner->preview,
        );
        $activity->dtimeCreate = (int) $this->owner->dtimeCreate;
        $activity->userId = (int) $this->owner->authorId;
        $activity->typeId = isset($this->owner->templateObject->data['type']) ? $this->owner->templateObject->data['type'] : 'post';

        return $activity;
    }

    public function getIsRemoved()
    {
        return $this->owner->isRemoved;
    }

}
