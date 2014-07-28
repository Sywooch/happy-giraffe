<?php

/**
 * Простая модель для монго-документа, реализует основные операции
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
abstract class HMongoModel extends CModel
{

    protected $_collection_name;
    protected $_db = 'happy_giraffe_db';
    protected $_collection;
    public $_id;

    public function init()
    {
        $this->attachBehaviors($this->behaviors());
    }

    /**
     * @return MongoCollection
     */
    protected function getCollection()
    {
        if (empty($this->_collection))
            $this->_collection = Yii::app()->edmsMongoCollection($this->_collection_name, $this->_db);

        return $this->_collection;
    }

    /**
     * Возвращает модель по id
     * @param $id int
     * @return array|null
     */
    public function findByPk($id)
    {
        return $this->getCollection()->findOne(array('_id' => new MongoId($id)));
    }

    public function findAllByPk($ids)
    {
        return $this->getCollection()->find(array('_id' => array('$in' => array_map(function($id)
                        {
                            return new MongoId($id);
                        }, $ids))));
    }

    /**
     * Удалить модель по id
     * @param $id
     */
    public function deleteByPk($id)
    {
        $this->getCollection()->remove(array('_id' => $id));
    }

    /**
     * Удалить модель
     */
    public function delete()
    {
        self::getCollection()->remove(array('_id' => $this->_id));
    }

    /**
     * This method is invoked after saving a record successfully.
     * The default implementation raises the {@link onAfterSave} event.
     * You may override this method to do postprocessing after record saving.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    protected function afterSave()
    {
        if ($this->hasEventHandler('onAfterSave'))
            $this->onAfterSave(new CEvent($this));
    }

    /**
     * This event is raised after the record is saved.
     * @param CEvent $event the event parameter
     */
    public function onAfterSave($event)
    {
        $this->raiseEvent('onAfterSave', $event);
    }

    protected function beforeSave()
    {
        if ($this->hasEventHandler('onBeforeSave'))
            $this->onBeforeSave(new CEvent($this));
    }

    public function onBeforeSave($event)
    {
        $this->raiseEvent('onBeforeSave', $event);
    }

    protected function beforeDelete()
    {
        if ($this->hasEventHandler('onBeforeDelete'))
            $this->onBeforeDelete(new CEvent($this));
    }

    public function onBeforeDelete($event)
    {
        $this->raiseEvent('onBeforeDelete', $event);
    }

    protected function afterDelete()
    {
        if ($this->hasEventHandler('onAfterDelete'))
            $this->onAfterDelete(new CEvent($this));
    }

    public function onAfterDelete($event)
    {
        $this->raiseEvent('onAfterDelete', $event);
    }

    protected function beforeFind()
    {
        if ($this->hasEventHandler('onBeforeFind'))
            $this->onBeforeFind(new CEvent($this));
    }

    public function onBeforeFind($event)
    {
        $this->raiseEvent('onBeforeFind', $event);
    }

    protected function afterFind()
    {
        if ($this->hasEventHandler('onAfterFind'))
            $this->onAfterFind(new CEvent($this));
    }

    public function onAfterFind($event)
    {
        $this->raiseEvent('onAfterFind', $event);
    }

}