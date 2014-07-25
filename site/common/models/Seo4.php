<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/05/14
 * Time: 12:29
 */

class Seo4 extends EMongoSoftDocument
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'seo4';
    }
}