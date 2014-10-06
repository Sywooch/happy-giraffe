<?php
/**
 * Обозреватель на основе ID
 *
 * Изначально загружает все ID коллекции, при запросе фотографий сначала выбирает из массива нужные ID, а уже потом
 * получает список объектов.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\observers;
use site\frontend\modules\photo\models\PhotoAttach;

class PhotoCollectionIdsObserver extends PhotoCollectionObserver
{
    /**
     * @var array id аттачей коллекции
     */
    private $_ids;

    public function getSingle($offset)
    {
        return PhotoAttach::model()->findByPk($this->ids[$offset]);
    }

    public function getSlice($length, $offset)
    {
        if ($this->getCount() == 0) {
            return array();
        }

        $ids = $this->roundSlice($this->ids, $offset, $length);
        $criteria = $this->getDefaultCriteria();
        $criteria->order = '';
        $criteria->addInCondition('t.id', $ids);
        $attaches = PhotoAttach::model()->findAll($criteria);
        return $attaches;
    }

    /**
     * Возвращает массив id всех аттачей коллекции в правильном порядке.
     *
     * @return array id аттачей коллекции
     */
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