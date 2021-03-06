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


use site\frontend\modules\photo\components\IPublicPhotoCollection;
use site\frontend\modules\photo\models\PhotoCollection;

class AlbumPhotoCollection extends PhotoCollection implements IPublicPhotoCollection
{
    public function getTitle()
    {
        return $this->RelatedModelBehavior->relatedModel->title;
    }

    public function getRelatedCollections()
    {
        return array(
            $this->RelatedModelBehavior->relatedModel->author->getPhotoCollection('default'),
        );
    }

    public function canMoveTo(PhotoCollection $collection)
    {
        return $collection instanceof AlbumPhotoCollection && $collection->RelatedModelBehavior->relatedModel->author_id == $this->RelatedModelBehavior->relatedModel->author_id;
    }
} 