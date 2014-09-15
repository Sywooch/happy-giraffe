<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 15/09/14
 * Time: 14:41
 */

namespace site\frontend\modules\photo\components\observers;


use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAttach;

class PhotoCollectionIdsObserver extends PhotoCollectionObserver
{
    private $_ids;

    public function getSingle($offset)
    {
        return PhotoAttach::model()->findByPk($this->ids[$offset]);
    }

    public function getSlice($length, $offset)
    {
        $ids = array_slice($this->ids, $offset, $length);
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t.id', $ids);
        $attaches = PhotoAttach::model()->findAll($criteria);

        usort($attaches, function($a, $b) {
            if ($a->position == $b->position) {
                return $a->id < $b->id ? -1 : 1;
            }
            return $a->position < $b->position ? -1 : 1;
        });

        return $attaches;
    }

    protected function getIds()
    {
        if ($this->_ids === null) {
            $alias = PhotoAttach::model()->getTableAlias();
            $sql = 'SELECT id FROM ' . PhotoAttach::model()->tableName() . ' ' . $alias . ' WHERE ' . $alias . '.collection_id = :collection_id ORDER BY ' . self::ORDER;
            $this->_ids = \Yii::app()->db->createCommand($sql)->queryColumn(array(':collection_id' => $this->model->id));
        }
        return $this->_ids;
    }
} 