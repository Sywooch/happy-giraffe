<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/6/13
 * Time: 10:27 AM
 * To change this template use File | Settings | File Templates.
 */

class UserPhotoCollection extends PhotoCollection
{
    public $userId;

    public function generateIds()
    {
        return Yii::app()->db->createCommand()
            ->select('id')
            ->from('album__photos')
            ->where(array('and', 'author_id = :userId AND hidden = 0 AND removed = 0', array('NOT IN', 'album_id', Album::model()->getUserSystemAlbumIds($this->userId))))
            ->order('id DESC')
            ->queryColumn(array(':userId' => $this->userId));
    }

    public function notEmpty()
    {
        return null != Yii::app()->db->createCommand()
            ->select('id')
            ->from('album__photos')
            ->where(array('and', 'author_id = :userId AND hidden = 0 AND removed = 0', array('NOT IN', 'album_id', Album::model()->getUserSystemAlbumIds($this->userId))))
            ->queryScalar(array(':userId' => $this->userId));
    }

    protected function getIdsCacheDependency()
    {
        $dependency = new CDbCacheDependency("SELECT COUNT(*), MAX(id) FROM album__photos WHERE author_id = :userId");
        $dependency->params = array(':userId' => $this->userId);
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
        $user = User::model()->findByPk($this->userId);
        return $user->url;
    }
}