<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Description of LikeBehavior
 *
 * @author Кирилл
 */
class FavoriteBehavior extends BaseBehavior
{

    public function attach($owner)
    {
        return parent::attach($owner);
    }

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord)
            $this->addNotification($this->owner);

        return parent::afterSave($event);
    }

    /**
     * 
     * @param \Favourite $model
     */
    protected function addNotification($model)
    {
        $entity = \CommunityContent::model($model->model_name)->findByPk($model->model_id);
        $notification = $this->findOrCreateNotification($model->model_name, (int) $model->model_id, $entity->author_id, \site\frontend\modules\notifications\models\Notification::TYPE_NEW_FAVOURITE, array($model->user_id, $model->user->getAvatarUrl(\Avatar::SIZE_MICRO)));

        $exists = false;
        if ($notification->unreadEntities)
            foreach ($notification->unreadEntities as $unreadFavorite)
            {
                if (!$exists && $unreadFavorite->userId == $model->user_id && $unreadFavorite->class == get_class($model))
                    $exists = true;
            }
        if (!$exists)
        {
            $favorite = new \site\frontend\modules\notifications\models\Entity($model);
            $favorite->userId = $model->user_id;
            $notification->unreadEntities[] = $favorite;
            $notification->save();
        }
    }

}

?>
