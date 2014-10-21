<?php
/**
 * Коллекция альбома по умолчанию
 *
 * Содержит все фотографии альбома
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\models\collections;


use site\frontend\modules\photo\models\PhotoCollection;

class AlbumPhotoCollection extends PhotoCollectionAbstract
{
    public function getCollectionLabel()
    {
        return 'Фотоальбом';
    }

    public function getCollectionTitle()
    {
        return $this->RelatedModelBehavior->relatedModel->relatedModel->title;
    }

    public function getCollectionDescription()
    {
        return $this->RelatedModelBehavior->relatedModel->description;
    }

    public function getRelatedCollections()
    {
        return array(
            //$this->RelatedModelBehavior->relatedModel->author->getPhotoCollection('default'),
        );
    }

    public function canMoveTo(PhotoCollection $collection)
    {
        return $collection instanceof AlbumPhotoCollection && $collection->RelatedModelBehavior->relatedModel->author_id == $this->RelatedModelBehavior->relatedModel->author_id;
    }

    public function getOwner()
    {
        return $this->RelatedModelBehavior->relatedModel->author;
    }
} 