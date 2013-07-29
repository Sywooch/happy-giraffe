<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/9/13
 * Time: 10:43 AM
 * To change this template use File | Settings | File Templates.
 */

abstract class PhotoCollection extends CComponent
{
    public $count;
    public $photoIds;

    public function __construct($options = array()) {
        $this->photoIds = $this->getPhotoIds();
        $this->count = count($this->photoIds);
        foreach ($options as $name => $value)
            $this->$name = $value;
    }

    public function getIndexById($photoId)
    {
        return array_search($photoId, $this->photoIds);
    }

    public function getAllPhotos()
    {
        return $this->populatePhotos($this->photoIds);
    }

    public function getPhotosInRange($photoId, $before, $after)
    {
        return $this->populatePhotos(array_merge($this->getPrevPhotosIds($photoId, $before), array($photoId), $this->getNextPhotosIds($photoId, $after)));
    }

    public function getNextPhotos($photoId, $after)
    {
        return $this->populatePhotos($this->getNextPhotosIds($photoId, $after));
    }

    public function getPrevPhotos($photoId, $before)
    {
        return $this->populatePhotos($this->getPrevPhotosIds($photoId, $before));
    }

    protected function getNextPhotosIds($photoId, $after)
    {
        $index = $this->getIndexById($photoId);

        if (($this->count - $index - 1) < $after)
            $rangeIds = array_merge(array_slice($this->photoIds, $index + 1), array_slice($this->photoIds, 0, $after + 1 - ($this->count - $index)));
        else
            $rangeIds = array_slice($this->photoIds, $index + 1, $after);

        return $rangeIds;
    }

    protected function getPrevPhotosIds($photoId, $before)
    {
        $index = $this->getIndexById($photoId);

        if ($index < $before)
            $rangeIds = array_merge(array_slice($this->photoIds, $index - $before), array_slice($this->photoIds, 0, $index));
        else
            $rangeIds = array_slice($this->photoIds, $index - $before, $before);

        return $rangeIds;
    }

    protected function getPhotoIds() {
        $value = Yii::app()->cache->get($this->getIdsCacheKey());
        if ($value === false) {
            $value = $this->generateIds();
            Yii::app()->cache->set($this->getIdsCacheKey(), $value, 0, $this->getIdsCacheDependency());
        }
        return $value;
    }

    protected function getIdsCacheKey() {
        return __CLASS__ . ':ids';
    }

    abstract protected function generateIds();
    abstract protected function getIdsCacheDependency();
    abstract protected function populatePhotos($ids);
    abstract protected function photoToJSON($model);
}