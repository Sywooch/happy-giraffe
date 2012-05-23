<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class StatusDates extends EMongoDocument
{
    public $entity_id;
    public $status;
    public $time;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'status_dates';
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->time = time();
        return parent::beforeSave();
    }


}