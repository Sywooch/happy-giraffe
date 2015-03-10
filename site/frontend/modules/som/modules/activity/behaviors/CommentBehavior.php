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

    public static $permittedClasses = array(
        'CommunityContent',
        'BlogContent',
    );
    protected $_content = null;

    public function events()
    {
        return array_merge(parent::events(), array(
            'onAfterSoftDelete' => 'afterSoftDelete',
            'onAfterSoftRestore' => 'afterSoftRestore',
        ));
    }

    public function afterSave($event)
    {
        if (in_array($this->owner->entity, self::$permittedClasses) && $this->content) {
            return parent::afterSave($event);
        }
    }

    public function afterSoftDelete($event)
    {
        if (in_array($this->owner->entity, self::$permittedClasses) && $this->content) {
            return parent::afterSave($event);
        }
    }

    public function afterSoftRestore($event)
    {
        if (in_array($this->owner->entity, self::$permittedClasses) && $this->content) {
            return parent::afterSave($event);
        }
    }

    public function getActivityId()
    {
        return md5('comments|' . $this->owner->id);
    }

    public function getActivityModel()
    {
        $activity = new Activity();
        $cover = false;
        if ($this->content->gallery) {
            $gallery = $this->content->gallery->items;
            if (isset($gallery[0]) && $gallery[0]->photo) {
                $newPhoto = \site\frontend\modules\photo\components\MigrateManager::movePhoto($gallery[0]->photo);
                if ($newPhoto) {
                    $cover = \Yii::app()->thumbs->getThumb($newPhoto, 'smallPostPreview')->url;
                }
            }
        }
        $activity->data = array(
            'url' => $this->owner->url,
            'text' => $this->owner->purified->text,
            'content' => array(
                'title' => $this->content->title,
                'url' => $this->content->url,
                'authorId' => $this->content->author_id,
                'dtimeCreate' => $this->content->getPubUnixTime(),
                'cover' => $cover,
            ),
        );
        $activity->dtimeCreate = (int) $this->owner->getPubUnixTime();
        $activity->userId = (int) $this->owner->author_id;
        $activity->typeId = 'comment';

        return $activity;
    }

    protected function getContent()
    {
        if (is_null($this->_content)) {
            $this->_content = \CActiveRecord::model($this->owner->entity)->findByPk($this->owner->entity_id);
            if (!$this->_content) {
                throw new \Exception('Нет оригинального контента, скорее всего он удалён.');
            }
        }

        return $this->_content;
    }

    public function getIsRemoved()
    {
        return $this->owner->removed;
    }

}
