<?php

class CommentatorSeVisit extends EMongoDocument
{
    public $user_id;
    public $period;
    public $entity;
    public $entity_id;
    public $value;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_production');
    }

    public function getCollectionName()
    {
        return 'commentator_se_visits';
    }

    public static function getStats($user_id, $period)
    {

    }
}
