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
    private $_options;

    public function __construct($options = array())
    {
        $this->_options = $options;
        foreach ($options as $name => $value)
            $this->$name = $value;
        $this->photoIds = $this->getPhotoIds();
        $this->count = count($this->photoIds);
    }

    public function getOptions()
    {
        return $this->_options;
    }

    public function getIndexById($photoId)
    {
        return array_search($photoId, $this->photoIds);
    }

    public function getAllPhotos($json = false)
    {
        return $this->populatePhotos($this->photoIds, $json);
    }

    public function getPhotosInRange($photoId, $before, $after, $json = true)
    {
        return $this->populatePhotos(array_merge($this->getPrevPhotosIds($photoId, $before), array($photoId), $this->getNextPhotosIds($photoId, $after)), $json);
    }

    public function getNextPhotos($photoId, $after, $json = true)
    {
        return $this->populatePhotos($this->getNextPhotosIds($photoId, $after), $json);
    }

    public function getPrevPhotos($photoId, $before, $json = true)
    {
        return $this->populatePhotos($this->getPrevPhotosIds($photoId, $before), $json);
    }

    protected function populatePhotos($ids, $json)
    {
        $models = count($ids) > 0 ? $this->generateModels($ids) : array();
        $_models = array_map(function($id) use ($models) {
            return $models[$id];
        }, $ids);
        return $json ? array_map(array($this, 'toJSON'), $_models) : $_models;
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
        return __CLASS__ . ':ids:' . serialize($this->options);
    }

    abstract protected function generateIds();
    abstract protected function getIdsCacheDependency();
    abstract protected function generateModels($ids);
    abstract protected function toJSON($model);
    abstract public function getUrl();
}