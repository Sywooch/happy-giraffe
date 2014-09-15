<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/09/14
 * Time: 14:42
 */

namespace site\frontend\modules\photo\components\observers;


use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class PhotoCollectionNeatObserver extends PhotoCollectionObserver
{
    public function getSingle($offset)
    {
        $criteria = $this->getDefaultCriteria();
        $criteria->offset = $offset;
        $criteria->limit = 1;
        return PhotoAttach::model()->find($criteria);
    }

    public function getSlice($length, $offset)
    {
        $criteria = $this->getDefaultCriteria();
        if ($offset < 0 && $length > abs($offset)) {
            $criteria->offset = $this->getCount() + $offset;
            $criteria->limit = abs($offset);
            $attaches = PhotoAttach::model()->findAll($criteria);

            $criteria->offset = 0;
            $criteria->limit = $length - abs($offset);
            $attaches2 = PhotoAttach::model()->findAll($criteria);

            return array_merge($attaches, $attaches2);
        } elseif (($this->getCount() - $offset) < $length) {
            $criteria->offset = $offset;
            $criteria->limit = $this->getCount() - $offset;
            $attaches = PhotoAttach::model()->findAll($criteria);

            $criteria->offset = 0;
            $criteria->limit = $length - $this->getCount() + $offset;
            $attaches2 = PhotoAttach::model()->findAll($criteria);

            return array_merge($attaches, $attaches2);
        } else {
            $criteria->offset = ($offset < 0) ? ($this->getCount() + $offset) : $offset;
            $criteria->limit = $length;
            return PhotoAttach::model()->findAll($criteria);
        }

    }

//    public function offsetSet($offset, $value)
//    {
//        $this->model->attaches[$offset] = $value;
//    }
//
//    public function offsetExists($offset)
//    {
//        return isset($this->model->attaches[$offset]);
//    }
//
//    public function offsetUnset($offset)
//    {
//        unset($this->model->attaches[$offset]);
//    }
//
//    public function offsetGet($offset)
//    {
//        return $this->model->attaches[$offset];
//    }
} 