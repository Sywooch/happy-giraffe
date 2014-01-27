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
            ),
            'commentsCount' => $model->commentsCount,
            'views' => PageView::model()->incViewsByPath($this->getUrl()),
        );
    }

    public function getUrl()
    {
        switch ($this->entityName) {
            case 'User':
                return $this->rootModel->getFamilyUrl();
            case 'UserPartner':
                return $this->rootModel->user->getFamilyUrl();
            case 'Baby':
                return $this->rootModel->parent->getFamilyUrl();
            case 'MessagingMessage':
                return '/messaging/';
        }
    }

    public function getTitle()
    {
        switch ($this->entityName) {
            case 'User':
                return $this->rootModel->getFullName();
            case 'UserPartner':
                return $this->rootModel->user->getFullName();
            case 'Baby':
                return $this->rootModel->parent->getFullName();
            default:
                return null;
        }
    }

    public function getLabel()
    {
        switch ($this->entityName) {
            case 'User':
            case 'UserPartner':
            case 'Baby':
                return 'Семейный альбом пользователя';
            case 'Comment':
                return 'Иллюстрации к комментарию';
            default:
                return null;
        }
    }

    public function getRootModel()
    {
        return CActiveRecord::model($this->entityName)->findByPk($this->entityId);
    }
}