<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/30/13
 * Time: 5:06 PM
 * To change this template use File | Settings | File Templates.
 */

class AlbumPhotoCollection extends PhotoCollection
{
    public $albumId;

    public function generateIds()
    {
        return Yii::app()->db->createCommand("SELECT id FROM album__photos WHERE album_id = :album_id AND hidden = 0 AND removed = 0 ORDER BY id ASC")->queryColumn(array(':album_id' => $this->albumId));
    }

    protected function getIdsCacheDependency()
    {
        $dependency = new CDbCacheDependency("SELECT COUNT(*) FROM album__photos WHERE album_id = :album_id");
        $dependency->params = array(':album_id' => $this->albumId);
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
        $album = Album::model()->findByPk($this->albumId);
        return $album->url;
    }
}