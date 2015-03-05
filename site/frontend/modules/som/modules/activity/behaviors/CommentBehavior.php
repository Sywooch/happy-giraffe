<?php

namespace site\frontend\modules\som\modules\activity\behaviors;

use site\frontend\modules\som\modules\activity\models\api\Activity;

/**
 * Description of CommentsBehavior
 *
 * @author Кирилл
 * 
 * @property \Comment $owner Owner
 */
class CommentBehavior extends ActivityBehavior
{

    public $permittedClasses = array(
        'CommunityContent',
        'BlogContent',
    );
    protected $_content = null;

    public function attach(\Comment $owner)
    {
        if (in_array($owner->entity, $this->permittedClasses)) {
            parent::attach($owner);
        }
    }

    public function getActivityId()
    {
        return md5($this->owner->originService . '|' . $this->owner->originEntity . '|' . $this->owner->originEntityId);
    }

    public function getActivityModel()
    {
        $activity = new Activiy();
        $cover = false;
        if($this->content->gallery) {
            $newPhoto = \site\frontend\modules\photo\components\MigrateManager::movePhoto($this->content->gallery->items[0]->photo);
            $cover = \Yii::app()->thumbs->getThumb($newPhoto, 'smallPostPreview');
        }
        $activity->data = array(
            'url' => $this->content->url,
            'text' => $this->owner->preview,
            'authorId' => $this->content->author_id,
            'cover' => $cover,
        );
        $activity->dtimeCreate = (int) $this->owner->dtimeCreate;
        $activity->userId = (int) $this->owner->authorId;
        $activity->typeId = isset($this->owner->templateObject->data['type']) ? $this->owner->templateObject->data['type'] : 'post';

        return $activity;
    }

    protected function getContent()
    {
        if (is_null($this->_content)) {
            $this->_content = \CActiveRecord::model($this->owner->entity)->findByPk($this->owner->entity_id);
        }

        return $this->_content;
    }

    public function getIsRemoved()
    {
        return $this->owner->removed;
    }

}
