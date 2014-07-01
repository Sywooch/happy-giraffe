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

    public function afterDelete($event)
    {
        parent::afterDelete($event);
    }

    /**
     * 
     * @param \HGLike $model
     */
    protected function addNotification($model)
    {
        $entity = \CommunityContent::model($model->entity_name)->findByPk($model->entity_id);
        
        $user = \User::model()->findByPk($model->user_id);
        
        $notification = $this->findOrCreateNotification($model->entity_name, (int) $model->entity_id, (int) $entity->author_id, \site\frontend\modules\notifications\models\Notification::TYPE_NEW_LIKE, array($model->user_id, $user->getAvaOrDefaultImage(\Avatar::SIZE_MICRO)));

        $exists = false;
        if ($notification->unreadEntities)
            foreach ($notification->unreadEntities as $unreadLike)
            {
                if (!$exists && $unreadLike->userId == $model->user_id && $unreadLike->class == get_class($model))
                    $exists = true;
            }
        if (!$exists)
        {
            $like = new \site\frontend\modules\notifications\models\Entity($model);
            $like->id = $model->_id;
            $like->userId = (int) $model->user_id;
            $notification->unreadEntities[] = $like;
            $notification->save();
        }
    }

}

?>
