<?php

class PhotoPostPhotoCollection extends PhotoCollection
{
    public $contentId;

    public function generateIds()
    {
        return Yii::app()->db->createCommand("SELECT photo_id FROM album__photo_attaches WHERE entity = 'CommunityContent' AND entity_id = :entity_id")->queryColumn(array(':entity_id' => $this->contentId));
    }

    protected function getIdsCacheDependency()
    {
        return Yii::app()->db->createCommand("SELECT COUNT(*) FROM album__photo_attaches WHERE entity = 'CommunityContent' AND entity_id = :entity_id")->queryColumn(array(':entity_id' => $this->contentId));
    }

    protected function populatePhotos($ids)
    {
        $criteria = new CDbCriteria(array(
            'index' => 'id',
            'with' => array(
                'photo' => array(
                    'with' => array('author'),
                ),
            ),
            'order' => new CDbExpression('FIELD(t.photo_id, ' . implode(',', $ids) . ')')
        ));
        $criteria->addInCondition('t.photo_id', $ids);
        $decorations = CookDecoration::model()->findAll($criteria);
        $results = array();
        foreach ($decorations as $d)
            $results[] = $this->populatePhoto($d);

        return $results;
    }

    protected function populatePhoto($attach)
    {
        return array(
            'id' => $decoration->photo_id,
            'title' => $decoration->title,
            'description' => $decoration->description,
            'src' => $decoration->photo->getPreviewUrl(804, null, Image::WIDTH),
            'date' => HDate::GetFormattedTime($decoration->created),
            'user' => array(
                'id' => $decoration->photo->author->id,
                'firstName' => $decoration->photo->author->first_name,
                'lastName' => $decoration->photo->author->last_name,
                'gender' => $decoration->photo->author->gender,
                'ava' => $decoration->photo->author->getAva('small'),
                'url' => $decoration->photo->author->url,
            ),
        );
    }
}