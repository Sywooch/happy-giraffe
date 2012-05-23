<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class StatusDates extends EMongoDocument
{
    public $entity;
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

    public static function getTime($model, $status){
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->status('==', (int)$status);

        $date = self::model()->find($criteria);
        if ($date !== null){
            return Yii::app()->dateFormatter->format("d MMMM y", $date->time);
        }else
            return null;
    }
}