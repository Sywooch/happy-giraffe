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
            WHERE pa.entity = :entityName AND pa.entity_id = :entityId AND p.removed = 0 AND p.hidden = 0
            ORDER BY pa.id DESC
        ";
        return Yii::app()->db->createCommand($sql)->queryColumn(array(':entityName' => $this->entityName, ':entityId' => $this->entityId));
    }

    protected function getIdsCacheDependency()
    {
        $dependency = new CDbCacheDependency("SELECT COUNT(*) FROM album__photo_attaches WHERE entity = :entityName AND entity_id = :entityId");
        $dependency->params = array(':entityName' => $this->entityName, ':entityId' => $this->entityId);
        return $dependency;
    }

    protected function generateModels($ids)
    {
        $criteria = new CDbCriteria(array(
            'with' => array('author'),
            'order' => new CDbExpression('FIELD(t.id, ' . implode(',', $ids) . ')')
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

    }
}