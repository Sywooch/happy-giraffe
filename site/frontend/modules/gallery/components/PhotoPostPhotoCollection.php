<?php

class PhotoPostPhotoCollection extends PhotoCollection
{
    public $contentId;

    public function generateIds()
    {
        return Yii::app()->db->createCommand("SELECT i.photo_id FROM community__content_gallery_items i INNER JOIN community__content_gallery g ON i.gallery_id = g.id WHERE g.content_id = :content_id")->queryColumn(array(':content_id' => $this->contentId));
    }

    protected function getIdsCacheDependency()
    {
        $dependency = new CDbCacheDependency("SELECT COUNT(*) FROM community__content_gallery_items i INNER JOIN community__content_gallery g ON i.gallery_id = g.id WHERE g.content_id = :content_id");
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
                'ava' => $model->photo->author->getAva('small'),
                'url' => $model->photo->author->url,
            ),
        );
    }

    public function getUrl()
    {

    }
}