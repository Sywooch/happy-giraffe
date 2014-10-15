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
        return $this->RelatedModelBehavior->title;
    }

    public function getCollectionDescription()
    {
        return $this->RelatedModelBehavior->description;
    }

    public function getRelatedCollections()
    {
        return array(
            $this->RelatedModelBehavior->author->getPhotoCollection('default'),
        );
    }

    public function canMoveTo(PhotoCollection $collection)
    {
        return $collection instanceof AlbumPhotoCollection && $collection->RelatedModelBehavior->author_id == $this->relateModel->author_id;
    }

    public function getOwner()
    {
        return $this->RelatedModelBehavior->author;
    }
} 