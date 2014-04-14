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
    public $rootModel;
    public $properties;
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
        $this->rootModel = $this->getRootModel();
        $this->properties = $this->getProperties();
    }

    public function getOptions()
    {
        return $this->_options;
    }

    public function getIndexById($photoId)
    {
        return array_search($photoId, $this->photoIds);
    }

    public function getPhoto($id, $json = false)
    {
        $p = $this->populatePhotos(array($id), $json);
        return $p[0];
    }

    public function getAllPhotos($limit = null, $json = false)
    {
        return $this->populatePhotos(array_slice($this->photoIds, 0, $limit), $json);
    }

    public function getPhotosInRange($photoId, $before, $after, $json = true)
    {
        return (($before + $after + 1) > $this->count) ? $this->getAllPhotos(null, true) : $this->populatePhotos(array_merge($this->getPrevPhotosIds($photoId, $before), array($photoId), $this->getNextPhotosIds($photoId, $after)), $json);
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
        if ($json) {
            $cacheKey = serialize($ids) . ':' . (int) $json;
            $value = Yii::app()->cache->get($cacheKey);
            if ($value === false) {
                $models = count($ids) > 0 ? $this->generateModels($ids) : array();
                $_models = array_map(function($id) use ($models) {
                    return $models[$id];
                }, $ids);
                $value = array_map(array($this, 'toJSON'), $_models);
                Yii::app()->cache->set($cacheKey, $value, 300);
            }
            return $value;
        } else {
            $models = count($ids) > 0 ? $this->generateModels($ids) : array();
            $_models = array_map(function($id) use ($models) {
                return $models[$id];
            }, $ids);
            return $_models;
        }
    }

    public function getNextPhotosIds($photoId, $after)
    {
        $index = $this->getIndexById($photoId);

        if (($this->count - $index - 1) < $after)
            $rangeIds = array_merge(array_slice($this->photoIds, $index + 1), array_slice($this->photoIds, 0, $after + 1 - ($this->count - $index)));
        else
            $rangeIds = array_slice($this->photoIds, $index + 1, $after);

        return $rangeIds;
    }

    public function getPrevPhotosIds($photoId, $before)
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
        $value = false;
        if ($value === false) {
            $value = $this->generateIds();
            Yii::app()->cache->set($this->getIdsCacheKey(), $value, 0, $this->getIdsCacheDependency());
        }
        return $value;
    }

    protected function getProperties()
    {
        return array(
            'title' => $this->getTitle(),
            'url' => $this->getUrl(),
            'label' => $this->getLabel(),
        );
    }

    protected function getTitle()
    {
        return $this->rootModel->title;
    }

    protected function getUrl()
    {
        return $this->rootModel->url;
    }

    protected function getIdsCacheKey() {
        return __CLASS__ . ':ids:' . serialize($this->options);
    }

    abstract protected function generateIds();
    abstract protected function getIdsCacheDependency();
    abstract protected function generateModels($ids);
    abstract protected function toJSON($model);
    abstract public function getRootModel();
}