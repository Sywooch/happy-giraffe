<?php
/**
 * Обозреватель коллекции.
 *
 * Позволяет получить единичное фото или набор из коллекции фотографий.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\observers;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

abstract class PhotoCollectionObserver extends \CComponent
{
    const ORDER = 't.position ASC, t.id ASC';

    /**
     * @var \site\frontend\modules\photo\models\PhotoCollection обозреваемая коллекция
     */
    protected $model;

    /**
     * @param \site\frontend\modules\photo\models\PhotoCollection $model модель фотоколлекции
     */
    public function __construct(PhotoCollection $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращает объект обозревателя для данной коллекции
     *
     * @param \site\frontend\modules\photo\models\PhotoCollection $model модель фотоколлекции
     * @return \site\frontend\modules\photo\components\observers\PhotoCollectionObserver объект обозревателя
     */
    public static function getObserver(PhotoCollection $model)
    {
        return new PhotoCollectionIdsObserver($model);
    }

    /**
     * Возвращает количество фотографий фотоколлекции
     *
     * @return int количество фотографий фотоколлекции
     */
    public function getCount()
    {

        return $this->model->attachesCount;
    }

    public function getNext($attachId)
    {
        if ($this->getCount() < 2) {
            return null;
        }
        $currentIndex = $this->getIndexByAttachId($attachId);
        $isLast = ($currentIndex + 1) == $this->getCount();
        $nextIndex = ($isLast) ? 0 : $currentIndex + 1;
        return $this->getSingle($nextIndex);
    }

    public function getPrev($attachId)
    {
        if ($this->getCount() < 2) {
            return null;
        }
        $currentIndex = $this->getIndexByAttachId($attachId);
        $isFirst = $currentIndex == 0;
        $next = ($isFirst) ? ($this->getCount() - 1) : $currentIndex - 1;
        return $this->getSingle($next);
    }

    public function getByAttach($attach)
    {
        if ($attach === null) {
            return null;
        }

        return $this->getByPhotoId($attach->photo_id);
    }

    public function getByPhotoId($photoId)
    {
        return PhotoAttach::model()->collection($this->model->id)->photo($photoId)->find();
    }

    /**
     * Возвращает критерию по умолчанию
     *
     * @return \CDbCriteria объект критерии
     */
    protected function getDefaultCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = self::ORDER;
        $criteria->with = 'photo';
        return $criteria;
    }

    protected function slice($array, $offset, $length, $circular)
    {
        return $circular ? $this->roundSlice($array, $offset, $length) : array_slice($array, $offset, $length);
    }

    /**
     * Расширенная реализация round_slice()
     *
     * В случае, если задано отрицательная смещения, отсчет ведется с конца массива
     *
     * @param array $array исходный массив
     * @param int $offset смещение
     * @param int $length длина выходного массива
     * @return array выходной массив
     */
    protected function roundSlice($array, $offset, $length)
    {
        if ($offset < 0) {
            $offset = $this->getCount() + $offset;
        }

        $result = array();
        for ($i = 0; $i < $length; $i++) {
            $idx = ($offset + $i) % $this->getCount();
            $result[] = $array[$idx];
        }
        return $result;
    }

    /**
     * Получение единичного аттача
     *
     * @param int $offset смещение
     * @return \site\frontend\modules\photo\models\PhotoAttach аттач
     */
    abstract public function getSingle($offset);

    /**
     * Получение
     *
     * @param int $length количество фотографи
     * @param int $offset смещение
     * @return \site\frontend\modules\photo\models\PhotoAttach[] массив аттачей
     */
    abstract public function getSlice($offset, $length = null, $circular = false);

    abstract public function getIndexByAttachId($attachId);
} 