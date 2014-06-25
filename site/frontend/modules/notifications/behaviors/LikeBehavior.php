<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Description of LikeBehavior
 *
 * @author Кирилл
 */
class LikeBehavior extends BaseBehavior
{

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord)
            $this->addNotification($this->owner);

        return parent::afterSave($event);
    }

    /**
     * 
     * @param \HGLike $model
     */
    protected function addNotification($model)
    {
        $entity = \CommunityContent::model($model->entity_name)->findByPk($model->entity_id);
        $notification = $this->findOrCreateNotification($model->entity_name, (int) $model->entity_id, $entity->author_id, \site\frontend\modules\notifications\models\Notification::TYPE_NEW_LIKE);
        $like = new \site\frontend\modules\notifications\models\Entity($model);
        $like->id = $model->_id;
        $notification->unreadEntities[] = $like;
        $notification->save();
    }

}

?>
