<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 16/09/14
 * Time: 15:23
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
        return $this->relatedModel->title;
    }

    public function getCollectionDescription()
    {
        return $this->relatedModel->description;
    }

    public function getRelatedCollections()
    {
        return array(
            $this->relatedModel->author->getCollection('all'),
        );
    }

    public function canMoveTo(PhotoCollection $collection)
    {
        return $collection instanceof AlbumPhotoCollection && $collection->relatedModel->author_id == $this->relateModel->author_id;
    }
} 