<?php
/**
 * "Аккуратный обозреватель"
 *
 * Получает только нужные фотографии, но реализация сложная и непроизводительная. Не используется.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\observers;
use site\frontend\modules\photo\models\PhotoAttach;

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
} 