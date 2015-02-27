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

        var_dump($this->owner->isRemoved);
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
        $activity->typeId = $this->owner->getPostType() == 'blog' ? 'blogContent' : 'communityContent';
        $activity->hash = $this->getActivityId();
        try {
            var_dump($activity->attributes);
            var_dump($activity->save());
        } catch (Exception $ex) {
            echo 'fail';
        }
    }

    public function delActivity()
    {
        try {
            var_dump(Activity::model()->request('removeByHash', array('hash' => $this->getActivityId())));
        } catch (\Exception $ex) {
            
        }
    }

}
