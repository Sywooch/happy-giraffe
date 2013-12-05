<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 13/11/13
 * Time: 17:09
 * To change this template use File | Settings | File Templates.
 */

class ContestPhotoCollection extends PhotoCollection
{
    const ORDER_CREATED = 'created';
    const ORDER_RATE = 'rate';

    public $contestId;
    public $order;

    public function generateIds()
    {
        if ($this->order == self::ORDER_CREATED)
            $sql = "
                SELECT photo_id
                FROM contest__works w
                JOIN album__photo_attaches a ON a.entity = 'ContestWork' AND a.entity_id = w.id
                WHERE w.contest_id = :contestId
                ORDER BY w.created DESC
            ";
        else
            $sql = "
                SELECT photo_id
                FROM contest__works w
                JOIN album__photo_attaches a ON a.entity = 'ContestWork' AND a.entity_id = w.id
                WHERE w.contest_id = :contestId
                ORDER BY w.rate DESC
            ";

        return Yii::app()->db->createCommand($sql)->queryColumn(array(':contestId' => $this->contestId));
    }

    protected function getIdsCacheDependency()
    {
        $sql = "
            SELECT COUNT(*), MAX(photo_id)
            FROM contest__works w
            JOIN album__photo_attaches a ON a.entity = 'ContestWork' AND a.entity_id = w.id
            WHERE w.contest_id = :contestId
        ";
        $dependency = new CDbCacheDependency($sql);
        $dependency->params = array(':contestId' => $this->contestId);
        return $dependency;
    }

    protected function generateModels($ids)
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photoAttach' => array(
                    'with' => array(
                        'photo' => array(
                            'with' => array('author'),
                        ),
                    ),
                ),
            ),
        ));
        $criteria->addInCondition('photo.id', $ids);
        $models = ContestWork::model()->findAll($criteria);
        $_models = array();
        foreach ($models as $m)
            $_models[$m->photoAttach->photo->id] = $m;
        return $_models;
    }

    protected function toJSON($model)
    {
        return array(
            'id' => $model->photoAttach->photo->id,
            'title' => $model->title,
            'description' => '',
            'src' => $model->photo->getPhotoViewUrl(),
            'date' => HDate::GetFormattedTime($model->photoAttach->photo->created),
            'user' => array(
                'id' => $model->photoAttach->photo->author->id,
                'firstName' => $model->photoAttach->photo->author->first_name,
                'lastName' => $model->photoAttach->photo->author->last_name,
                'gender' => $model->photoAttach->photo->author->gender,
                'ava' => $model->photoAttach->photo->author->getAvatarUrl(),
                'url' => $model->photoAttach->photo->author->url,
            ),
            'likesCount' => PostRating::likesCount($model->photoAttach->photo),
            'isLiked' => ! Yii::app()->user->isGuest && Yii::app()->user->model->isLiked($model->photoAttach->photo),
            'favourites'=>array(
                'count' => (int) Favourite::model()->getCountByModel($model->photoAttach->photo),
                'active' => (bool) Favourite::model()->getUserHas(Yii::app()->user->id, $model->photoAttach->photo),
            ),
            'commentsCount' => $model->photoAttach->photo->commentsCount,
            'views' => PageView::model()->incViewsByPath($this->rootModel->url . $model->photoAttach->photo->id . '/'),
        );
    }

    public function getLabel()
    {
        return 'Конкурс';
    }

    public function getRootModel()
    {
        return Contest::model()->findByPk($this->contestId);
    }
}