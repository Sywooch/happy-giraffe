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

    public function getSlice($offset, $length = null, $circular = false)
    {
        if ($this->getCount() == 0) {
            return array();
        }

        $ids = ($length == null && $offset == 0) ? $this->ids : $this->slice($this->ids, $offset, $length, $circular);
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
            $criteria = PhotoAttach::model()->collection($this->model->id)->getDbCriteria();
            $criteria->select = 'id';
            $criteria->order = self::ORDER;
            $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(PhotoAttach::model()->tableName(), $criteria);
            $this->_ids = $command->queryColumn();
        }
        return $this->_ids;
    }
} 