<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/30/13
 * Time: 10:09 AM
 * To change this template use File | Settings | File Templates.
 */

class AttachPhotoCollection extends PhotoCollection
{
    public $entityName;
    public $entityId;

    public function generateIds()
    {
        $sql = "
            SELECT photo_id
            FROM album__photo_attaches pa
            JOIN album__photos p ON p.id = pa.photo_id
            WHERE pa.entity = :entityName AND pa.entity_id = :entityId AND p.removed = 0
            ORDER BY pa.id ASC
        ";
        return Yii::app()->db->createCommand($sql)->queryColumn(array(':entityName' => $this->entityName, ':entityId' => $this->entityId));
    }

    protected function getIdsCacheDependency()
    {
        $sql = "
            SELECT COUNT(*), MAX(p.id)
            FROM album__photo_attaches pa
            JOIN album__photos p ON p.id = pa.photo_id
            WHERE pa.entity = :entityName AND pa.entity_id = :entityId AND p.removed = 0
        ";
        $dependency = new CDbCacheDependency($sql);
        $dependency->params = array(':entityName' => $this->entityName, ':entityId' => $this->entityId);
        return $dependency;
    }

    protected function generateModels($ids)
    {
        $criteria = new CDbCriteria(array(
            'with' => array('author'),
            'index' => 'id',
        ));
        $criteria->addInCondition('t.id', $ids);
        return AlbumPhoto::model()->findAll($criteria);
    }

    protected function toJSON($model)
    {
        return array(
            'id' => $model->id,
            'title' => $model->title,
            'description' => '',
            'src' => $model->getOriginalUrl(),
            'date' => HDate::GetFormattedTime($model->created),
            'user' => array(
                'id' => $model->author->id,
                'firstName' => $model->author->first_name,
                'lastName' => $model->author->last_name,
                'gender' => $model->author->gender,
                'ava' => $model->author->getAvatarUrl(),
                'url' => $model->author->url,
            ),
            'likesCount' => PostRating::likesCount($model),
            'isLiked' => ! Yii::app()->user->isGuest && Yii::app()->user->model->isLiked($model),
            'favourites'=>array(
                'count' => (int) Favourite::model()->getCountByModel($model),
                'active' => (bool) Favourite::model()->getUserHas(Yii::app()->user->id, $model),
            )
        );
    }

    public function getUrl()
    {
        switch ($this->entityName) {
            case 'User':
                $user = User::model()->findByPk($this->entityId);
                return $user->getFamilyUrl();
            case 'UserPartner':
                $user = UserPartner::model()->findByPk($this->entityId)->user;
                return $user->getFamilyUrl();
            case 'Baby':
                $user = Baby::model()->findByPk($this->entityId)->parent;
                return $user->getFamilyUrl();
        }
    }

    public function getTitle()
    {
        switch ($this->entityName) {
            case 'User':
                $user = User::model()->findByPk($this->entityId);
                return 'Семейный альбом пользователя ' . $user->getFullName();
            case 'UserPartner':
                $user = UserPartner::model()->findByPk($this->entityId)->user;
                return 'Семейный альбом пользователя ' . $user->getFullName();
            case 'Baby':
                $user = Baby::model()->findByPk($this->entityId)->parent;
                return 'Семейный альбом пользователя ' . $user->getFullName();
            case 'Comment':
                return 'Иллюстрации к комментарию';
        }
    }
}