<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class ServiceData extends EMongoDocument
{
    public $title;
    public $text;
    public $image;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'service_data';
    }
}