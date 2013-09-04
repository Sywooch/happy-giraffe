<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/4/13
 * Time: 2:25 PM
 * To change this template use File | Settings | File Templates.
 */

class ContentGalleryPhotoCollection extends PhotoCollection
{
    public $contentId;

    public function generateIds()
    {
        $sql = "
            SELECT i.photo_id
            FROM community__content_gallery_items i
            INNER JOIN community__content_gallery g ON i.gallery_id = g.id
            WHERE g.content_id = :content_id;
        ";
        return Yii::app()->db->createCommand($sql)->queryColumn(array(':content_id' => $this->contentId));
    }

    protected function getIdsCacheDependency()
    {
        $sql = "
            SELECT COUNT(*)
            FROM community__content_gallery_items i
            INNER JOIN community__content_gallery g ON i.gallery_id = g.id
            WHERE g.content_id = :content_id;
        ";
        $dependency = new CDbCacheDependency($sql);
        $dependency->params = array(':content_id' => $this->contentId);
        return $dependency;
    }

    protected function generateModels($ids)
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photo' => array(
                    'with' => array('author'),
                ),
            ),
            'order' => new CDbExpression('FIELD(t.photo_id, ' . implode(',', $ids) . ')')
        ));
        $criteria->addInCondition('t.photo_id', $ids);
        return CommunityContentGalleryItem::model()->findAll($criteria);
    }

    protected function toJSON($model)
    {
        return array(
            'id' => $model->photo_id,
            'title' => '',
            'description' => $model->description,
            'src' => $model->photo->getOriginalUrl(),
            'date' => HDate::GetFormattedTime($model->photo->created),
            'user' => array(
                'id' => $model->photo->author->id,
                'firstName' => $model->photo->author->first_name,
                'lastName' => $model->photo->author->last_name,
                'gender' => $model->photo->author->gender,
                'ava' => $model->photo->author->getAvatarUrl(),
                'url' => $model->photo->author->url,
            ),
            'likesCount' => PostRating::likesCount($model->photo),
            'isLiked' => ! Yii::app()->user->isGuest && Yii::app()->user->model->isLiked($model->photo),
            'favourites'=>array(
                'count' => (int) Favourite::model()->getCountByModel($model->photo),
                'active' => (bool) Favourite::model()->getUserHas(Yii::app()->user->id, $model->photo),
            )
        );
    }

    public function getUrl()
    {
        $post = CommunityContent::model()->findByPk($this->contentId);
        return $post->url;
    }
}