<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/09/14
 * Time: 14:43
 */

namespace site\frontend\modules\photo\components\observers;


use site\frontend\modules\photo\models\PhotoCollection;

abstract class PhotoCollectionObserver extends \CComponent
{
    const ORDER = 't.position ASC, t.id ASC';

    protected $model;

    public function __construct(PhotoCollection $model)
    {
        $this->model = $model;
    }

    public function getCount()
    {
        return $this->model->attachesCount;
    }

    protected function getDefaultCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = self::ORDER;
        $criteria->with = 'photo';
        return $criteria;
    }

    protected function roundSlice($array, $offset, $length)
    {
        $result = array();
        for ($i = 0; $i < $length; $i++) {
            $idx = (abs($offset + $i)) % $this->getCount();
            $result[] = $array[$idx];
        }
        return $result;
    }

    abstract public function getSingle($offset);
    abstract public function getSlice($length, $offset);
} 